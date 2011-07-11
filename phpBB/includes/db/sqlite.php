<?php
/**
*
* @package dbal
* @copyright (c) 2011 Boris Berdichevski
* @copyright (c) 2011 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

include_once($phpbb_root_path . 'includes/db/dbal.' . $phpEx);

/**
* Sqlite Database Abstraction Layer
*
* This file is largely based upon
* <http://www.phpbb.com/community/viewtopic.php?f=70&t=1059695>
*
* @package dbal
*/
class dbal_sqlite extends dbal
{
	private $conn;

	/**
	* Connect to server
	*/
	function sql_connect($sqlserver, $sqluser, $sqlpassword, $database, $port = false, $persistency = false, $new_link = false)
	{
		$this->server		= $sqlserver;
		$this->persistency	= $persistency;

		$this->sql_layer = 'sqlite';

		$this->open_queries = new SplObjectStorage();

		try
		{
			$this->conn = new SQLite3($this->server);
			$this->conn->exec('PRAGMA short_column_names = 1');
			$this->conn->exec('PRAGMA encoding = "UTF-8"');
		}
		catch (Exception $error)
		{
			return array(
				'code'		=> $error->getCode(),
				'message' 	=> $error->getMessage(),
			);
		}

		return true;
	}

	/**
	* Version information about used database
	*
	* @param bool $raw if true, only return the fetched sql_server_version
	* @param bool $use_cache if true, it is safe to retrieve the stored value from the cache
	* @return string sql server version
	*/
	function sql_server_info($raw = false, $use_cache = true)
	{
		global $cache;

		if (!$use_cache || empty($cache) || ($this->sql_server_version = $cache->get('sqlite_version')) === false)
		{
			$vers = SQLite3::version();

			$this->sql_server_version = $vers['versionString'];

			if (!empty($cache) && $use_cache)
			{
				$cache->put('sqlite_version', $this->sql_server_version);
			}
		}

		return ($raw) ? $this->sql_server_version : 'SQLite ' . $this->sql_server_version;
	}

	/**
	* SQL Transaction
	*/
	function _sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				return $this->conn->query('BEGIN');
			break;

			case 'commit':
				return $this->conn->query('COMMIT');
			break;

			case 'rollback':
				return $this->conn->query('ROLLBACK');
			break;
		}

		return true;
	}

	/**
	* Base query method
	*
	* @param	string	$query		Contains the SQL query which shall be executed
	* @param	int		$cache_ttl	Either 0 to avoid caching or the time in seconds which the result shall be kept in cache
	* @return	mixed				When casted to bool the returned value returns true on success and false on failure
	*
	*/
	function sql_query($query = '', $cache_ttl = 0)
	{
		global $cache;

		if ($query != '')
		{
			// EXPLAIN only in extra debug mode
			if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('start', $query);
			}

			$this->query_result = ($cache_ttl && method_exists($cache, 'sql_load')) ? $cache->sql_load($query) : false;
			$this->sql_add_num_queries($this->query_result);

			if ($this->query_result === false)
			{
				if (strpos($query, 'SELECT') !== 0 && strpos($query, 'PRAGMA') !== 0)
				{
					if ($this->return_on_error)
					{
						$error_reporting = error_reporting(0);
					}

					try
					{
						$this->query_result = $this->conn->exec($query);
					}
					catch (Exception $error)
					{
						$this->sql_error($query);
						$this->query_result = false;
					}

					if ($this->return_on_error)
					{
						error_reporting($error_reporting);
					}
				}
				else
				{
					try
					{
						$this->query_result = $this->conn->query($query);
					}
					catch (Exception $error)
					{
						$this->sql_error($query);
						$this->query_result = false;
					}
				}

				if (defined('DEBUG_EXTRA'))
				{
					$this->sql_report('stop', $query);
				}

				if ($cache_ttl && method_exists($cache, 'sql_save'))
				{
					$this->open_queries->attach($this->query_result);
					$cache->sql_save($query, $this->query_result, $cache_ttl);
				}
				else if (strpos($query, 'SELECT') === 0 && $this->query_result)
				{
					$this->open_queries->attach($this->query_result);
				}
			}
			else if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('fromcache', $query);
			}
		}
		else
		{
			return false;
		}

		return $this->query_result;
	}

	/**
	* Build LIMIT query
	*/
	function _sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		$this->query_result = false;

		// if $total is set to 0 we do not want to limit the number of rows
		if ($total == 0)
		{
			$total = -1;
		}

		$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

		return $this->sql_query($query, $cache_ttl);
	}

	/**
	* Return number of affected rows
	*/
	function sql_affectedrows()
	{
		return ($this->conn) ? $this->conn->changes() : false;
	}

	/**
	* Fetch current row
	*/
	function sql_fetchrow($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if (isset($cache->sql_rowset[$query_id]))
		{
			return $cache->sql_fetchrow($query_id);
		}

		if ($query_id === false || !isset($query_id) || !is_object($query_id))
		{
			return false;
		}

		return $query_id->fetchArray(SQLITE3_ASSOC);
	}

	/**
	* Seek to given row number
	* rownum is zero-based
	*/
	function sql_rowseek($rownum, &$query_id)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if (isset($cache) && isset($cache->sql_rowset[$query_id]))
		{
			return $cache->sql_rowseek($rownum, $query_id);
		}

		// @todo This seems largely useless currently :-/
		return true; //($query_id !== false) ? @sqlite_seek($query_id, $rownum) : false;
	}

	/**
	* Get last inserted id after insert statement
	*/
	function sql_nextid()
	{
		return $this->conn->lastInsertRowID();
	}

	/**
	* Free sql result
	*/
	function sql_freeresult($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if (isset($cache->sql_rowset[$query_id]))
		{
			return $cache->sql_freeresult($query_id);
		}

		if ($query_id && $this->open_queries->contains($query_id))
		{
			$this->open_queries->detach($query_id);
			return $query_id->finalize();
		}

		return false;
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		return SQLite3::escapeString($msg);
	}

	/**
	* Correctly adjust LIKE expression for special characters
	* For SQLite an underscore is a not-known character... this may change with SQLite3
	*
	* @todo Does this still stand for SQLite3?
	*/
	function sql_like_expression($expression)
	{
		// Unlike LIKE, GLOB is case sensitive (unfortunatly). SQLite users need to live with it!
		// We only catch * and ? here, not the character map possible on file globbing.
		$expression = str_replace(array(chr(0) . '_', chr(0) . '%'), array(chr(0) . '?', chr(0) . '*'), $expression);

		$expression = str_replace(array('?', '*'), array("\?", "\*"), $expression);
		$expression = str_replace(array(chr(0) . "\?", chr(0) . "\*"), array('?', '*'), $expression);

		return 'GLOB \'' . $this->sql_escape($expression) . '\'';
	}

	/**
	* return sql error array
	*/
	function _sql_error()
	{
		return array(
			'message'	=> $this->conn->lastErrorMsg(),
			'code'		=> $this->conn->lastErrorCode()
		);
	}

	/**
	* Build db-specific query data
	*/
	function _sql_custom_build($stage, $data)
	{
		return $data;
	}

	/**
	* Close sql connection
	*/
	function _sql_close()
	{
		return $this->conn->close();
	}

	/**
	* Build db-specific report
	*/
	function _sql_report($mode, $query = '')
	{
		switch ($mode)
		{
			case 'start':
			break;

			case 'fromcache':
				$endtime = microtime(true);

				$result = $this->conn->query($query);
				while ($void = $result->fetchArray(SQLITE3_ASSOC))
				{
					// Take the time spent on parsing rows into account
				}

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

				$result->finalize();
			break;
		}
	}

	/**
	* Return column types
	* @todo Where has this come from?
	*/
	function fetch_column_types($table_name)
	{
		$col_types = array();

		$result = $this->conn->query("PRAGMA table_info('$table_name')");
		while ($row = $col_info_res->fetchArray(SQLITE3_ASSOC))
		{
			$column_name = $row['name'];
			$column_type = $row['type'];
			$col_types[$column_name] = $column_type;
		}
		$result->finalize();

		return $col_types;
	}
}
