<?php
/**
*
* @package dbal
* @version $Id$
* @copyright (c) 2010 phpBB Group
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
* PDO DBAL driver/adapter
* @package dbal
*/
class dbal_pdo extends dbal
{
	var $multi_insert = true;

	/**
	* Connect to server
	* $sqlserver must be the DSN, eg. mysql:dbname=phpbb;host=localhost
	* $database and $port are ignored
	*/
	function sql_connect($sqlserver, $sqluser, $sqlpassword, $database, $port = false, $persistency = false , $new_link = false)
	{
		$this->server = $sqlserver;
		$this->user = $sqluser;
		$this->dbname = $database;
		$this->persistency = $persistency;

		$pdo_options = array();
		if ($this->persistency)
		{
			$pdo_options[PDO::ATTR_PERSISTENT] = true;
		}
		if (strpos($this->server, 'mysql') !== false)
		{
			// take care of UTF-8 encoding
			$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
		}

		try
		{
			$this->db_connect_id = new PDO($this->server, $this->user, $sqlpassword, $pdo_options);
		}
		catch (PDOException $e)
		{
			return $this->sql_error('');
		}

		return true;
	}

	/**
	* Version information about used database
	* @param bool $raw if true, only return the fetched sql_server_version
	* @return string sql server version
	*/
	function sql_server_info($raw = false)
	{
		global $cache;

		if (empty($cache) || ($this->sql_server_version = $cache->get('mysqli_version')) === false)
		{
			$result = @mysqli_query($this->db_connect_id, 'SELECT VERSION() AS version');
			$row = @mysqli_fetch_assoc($result);
			@mysqli_free_result($result);

			$this->sql_server_version = $row['version'];

			if (!empty($cache))
			{
				$cache->put('mysqli_version', $this->sql_server_version);
			}
		}

		return ($raw) ? $this->sql_server_version : 'MySQL(i) ' . $this->sql_server_version;
	}

	/**
	* SQL Transaction
	* @access private
	*/
	function _sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				return $this->db_connect_id->beginTransaction();
			break;

			case 'commit':
				return $this->db_connect_id->commit();
			break;

			case 'rollback':
				return $this->db_connect_id->rollBack();
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
	* @access	public
	*/
	function sql_query($query = '', $cache_ttl = 0)
	{
		if ($query == '')
		{
			return false;
		}

		global $cache;

		// EXPLAIN only in extra debug mode
		if (defined('DEBUG_EXTRA'))
		{
			$this->sql_report('start', $query);
		}

		$this->query_result = ($cache_ttl && method_exists($cache, 'sql_load')) ? $cache->sql_load($query) : false;
		$this->sql_add_num_queries($this->query_result);

		if ($this->query_result === false)
		{
			try
			{
				$this->query_result = $this->db_connect_id->query($query);
			}
			catch (PDOException $e)
			{
				$this->sql_error($query);
			}

			if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('stop', $query);
			}

			if ($cache_ttl && method_exists($cache, 'sql_save'))
			{
				$cache->sql_save($query, $this->query_result, $cache_ttl);
			}
		}
		else if (defined('DEBUG_EXTRA'))
		{
			$this->sql_report('fromcache', $query);
		}

		return $this->query_result;
	}

	/**
	* Build LIMIT query
	*/
	function _sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		$this->query_result = false;

		$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

		return $this->sql_query($query, $cache_ttl);
	}

	/**
	* Return number of affected rows
	*/
	function sql_affectedrows()
	{
		return ($this->query_result) ? $this->query_result->rowCount() : false;
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

		if (!is_object($query_id) && isset($cache->sql_rowset[$query_id]))
		{
			return $cache->sql_fetchrow($query_id);
		}

		return ($query_id !== false) ? $query_id->fetch(PDO::FETCH_ASSOC) : false;
	}

	/**
	* Seek to given row number
	* rownum is zero-based
	*/
	function sql_rowseek($rownum, &$query_id)
	{
		// not supported
		trigger_error('sql_rowseek is not supported by PDO dbal driver', E_USER_ERROR);
	}

	/**
	* Get last inserted id after insert statement
	*/
	function sql_nextid()
	{
		return ($this->db_connect_id) ? $this->db_connect_id->lastInsertId() : false;
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

		if (!is_object($query_id) && isset($cache->sql_rowset[$query_id]))
		{
			return $cache->sql_freeresult($query_id);
		}

		$this->query_result = null;

		return true;
	}

	/**
	* Escape string used in sql query
	* PDO includes the surrounding quotes, so we must strip them
	*/
	function sql_escape($msg)
	{
		return substr($this->db_connect_id->quote($msg), 1, -1);
	}

	/**
	* Build LIKE expression
	* @access private
	*/
	function _sql_like_expression($expression)
	{
		return $expression;
	}

	/**
	* Build db-specific query data
	* @access private
	*/
	function _sql_custom_build($stage, $data)
	{
		switch ($stage)
		{
			case 'FROM':
				$data = '(' . $data . ')';
			break;
		}

		return $data;
	}

	/**
	* return sql error array
	* @access private
	*/
	function _sql_error()
	{
		if (!$this->db_connect_id)
		{
			return array(
				'message'	=> @mysqli_connect_error(),
				'code'		=> @mysqli_connect_errno()
			);
		}

		return array(
			'message'	=> @mysqli_error($this->db_connect_id),
			'code'		=> @mysqli_errno($this->db_connect_id)
		);
	}

	/**
	* Close sql connection
	* @access private
	*/
	function _sql_close()
	{
		$this->db_connect_id = null;
	}

	/**
	* Build db-specific report
	* @access private
	*/
	function _sql_report($mode, $query = '')
	{
		static $test_prof;

		// current detection method, might just switch to see the existance of INFORMATION_SCHEMA.PROFILING
		if ($test_prof === null)
		{
			$test_prof = false;
			if (strpos(mysqli_get_server_info($this->db_connect_id), 'community') !== false)
			{
				$ver = mysqli_get_server_version($this->db_connect_id);
				if ($ver >= 50037 && $ver < 50100)
				{
					$test_prof = true;
				}
			}
		}

		switch ($mode)
		{
			case 'start':

				$explain_query = $query;
				if (preg_match('/UPDATE ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}
				else if (preg_match('/DELETE FROM ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}

				if (preg_match('/^SELECT/', $explain_query))
				{
					$html_table = false;

					// begin profiling
					if ($test_prof)
					{
						@mysqli_query($this->db_connect_id, 'SET profiling = 1;');
					}

					if ($result = @mysqli_query($this->db_connect_id, "EXPLAIN $explain_query"))
					{
						while ($row = @mysqli_fetch_assoc($result))
						{
							$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
						}
					}
					@mysqli_free_result($result);

					if ($html_table)
					{
						$this->html_hold .= '</table>';
					}

					if ($test_prof)
					{
						$html_table = false;

						// get the last profile
						if ($result = @mysqli_query($this->db_connect_id, 'SHOW PROFILE ALL;'))
						{
							$this->html_hold .= '<br />';
							while ($row = @mysqli_fetch_assoc($result))
							{
								// make <unknown> HTML safe
								if (!empty($row['Source_function']))
								{
									$row['Source_function'] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $row['Source_function']);
								}

								// remove unsupported features
								foreach ($row as $key => $val)
								{
									if ($val === null)
									{
										unset($row[$key]);
									}
								}
								$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
							}
						}
						@mysqli_free_result($result);

						if ($html_table)
						{
							$this->html_hold .= '</table>';
						}

						@mysqli_query($this->db_connect_id, 'SET profiling = 0;');
					}
				}

			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = @mysqli_query($this->db_connect_id, $query);
				while ($void = @mysqli_fetch_assoc($result))
				{
					// Take the time spent on parsing rows into account
				}
				@mysqli_free_result($result);

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

			break;
		}
	}
}
