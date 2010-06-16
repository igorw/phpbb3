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

class phpbb_db_query_mysql extends phpbb_db_query_driver
{
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	public function get_name()
	{
		return 'MySQL';
	}

	public function on_connect()
	{
		$this->db->sql_query("SET NAMES 'utf8'");

		// enforce strict mode on databases that support it
		if (version_compare($this->server_info(true), '5.0.2', '>='))
		{
			$result = $this->db->sql_query($this->db->db_connect_id, 'SELECT @@session.sql_mode AS sql_mode');
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$modes = array_map('trim', explode(',', $row['sql_mode']));

			// TRADITIONAL includes STRICT_ALL_TABLES and STRICT_TRANS_TABLES
			if (!in_array('TRADITIONAL', $modes))
			{
				if (!in_array('STRICT_ALL_TABLES', $modes))
				{
					$modes[] = 'STRICT_ALL_TABLES';
				}

				if (!in_array('STRICT_TRANS_TABLES', $modes))
				{
					$modes[] = 'STRICT_TRANS_TABLES';
				}
			}

			$mode = implode(',', $modes);
			$this->db->sql_query("SET SESSION sql_mode='{$mode}'");
		}
	}

	/**
	* Version information about used database
	* @param bool $raw if true, only return the fetched sql_server_version
	* @return string sql server version
	*/
	public function server_info($raw = false)
	{
		global $cache;

		if (empty($cache) || ($this->server_version = $cache->get('mysqli_version')) === false)
		{
			$result = $this->db->sql_query($this->db_connect_id, 'SELECT VERSION() AS version');
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$this->server_version = $row['version'];

			if (!empty($cache))
			{
				$cache->put('mysqli_version', $this->server_version);
			}
		}

		return ($raw) ? $this->server_version : $this->get_name() . ' ' . $this->server_version;
	}

	/**
	* Build LIMIT query
	*/
	public function query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		$this->query_result = false;

		// if $total is set to 0 we do not want to limit the number of rows
		if ($total == 0)
		{
			// MySQL 4.1+ no longer supports -1 in limit queries
			$total = '18446744073709551615';
		}

		$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

		return $this->db->sql_query($query, $cache_ttl);
	}

	/**
	* Build LIKE expression
	*/
	public function like_expression($expression)
	{
		return $expression;
	}

	/**
	* Build db-specific query data
	*/
	public function custom_build($stage, $data)
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
	* Build db-specific report
	* @access private
	*/
	public function _sql_report($mode, $query = '')
	{
		static $test_prof;

		// check if profiling is enabled
		if ($test_prof === null)
		{
			$sql = "SELECT COUNT(*) as test_prof
				FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = 'INFORMATION_SCHEMA'
				AND TABLE_NAME = 'PROFILING'";
			$result = $this->db->sql_query($sql);
			$test_prof = (bool) $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
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
						$this->db->sql_query($this->db_connect_id, 'SET profiling = 1;');
					}

					if ($result = $this->db->sql_query($this->db_connect_id, "EXPLAIN $explain_query"))
					{
						while ($row = $this->db->sql_fetchrow($result))
						{
							$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
						}
					}
					$this->db->sql_freeresult($result);

					if ($html_table)
					{
						$this->html_hold .= '</table>';
					}

					if ($test_prof)
					{
						$html_table = false;

						// get the last profile
						if ($result = $this->db->sql_query($this->db_connect_id, 'SHOW PROFILE ALL;'))
						{
							$this->html_hold .= '<br />';
							while ($row = $this->db->sql_fetchrow($result))
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
							$this->db->sql_freeresult($result);
						}

						if ($html_table)
						{
							$this->html_hold .= '</table>';
						}

						$this->db->sql_query($this->db_connect_id, 'SET profiling = 0;');
					}
				}

			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = $this->db->sql_query($this->db_connect_id, $query);
				while ($void = $this->db->sql_fetchrow($result))
				{
					// Take the time spent on parsing rows into account
				}
				$this->db->sql_freeresult($result);

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

			break;
		}
	}
}
