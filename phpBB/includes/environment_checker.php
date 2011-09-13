<?php
/**
*
* @package phpBB
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

class phpbb_environment_checker
{
	var $phpbb_root_path;
	var $phpEx;
	var $config;
	var $auth;

	function phpbb_environment_checker($phpbb_root_path, $phpEx, $config, $auth)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->phpEx = $phpEx;
		$this->config = $config;
		$this->auth = $auth;
	}

	function get_errors($custom_checks = array(), $only_custom_checks = false)
	{
		if (!class_exists('phpbb_assertion_manager'))
		{
			include($this->phpbb_root_path . 'includes/assertion_manager.' . $this->phpEx);
		}

		if (!class_exists('phpbb_ini_reader'))
		{
			include($this->phpbb_root_path . 'includes/ini_reader.' . $this->phpEx);
		}

		$asserter = new phpbb_assertion_manager;
		$php_ini = new phpbb_ini_reader;
		$mbstring = extension_loaded('mbstring');

		if (!$only_custom_checks)
		{
			$checks_array = array(
				'ERROR_REGISTER_GLOBALS'				=> !$php_ini->get_bool('register_globals'),
				'ERROR_MBSTRING_FUNC_OVERLOAD'			=> !$mbstring || !($php_ini->get_int('mbstring.func_overload') & (MB_OVERLOAD_MAIL | MB_OVERLOAD_STRING)),
				'ERROR_MBSTRING_ENCODING_TRANSLATION'	=> !$mbstring || !$php_ini->get_bool('mbstring.encoding_translation'),
				'ERROR_MBSTRING_HTTP_INPUT'				=> !$mbstring || $php_ini->get_string('mbstring.http_input') == 'pass',
				'ERROR_MBSTRING_HTTP_OUTPUT'			=> !$mbstring || $php_ini->get_string('mbstring.http_output') == 'pass',
				'ERROR_GETIMAGESIZE_SUPPORT'			=> function_exists('getimagesize'),
				'ERROR_REMOVE_INSTALL'					=> !file_exists($this->phpbb_root_path . 'install') || is_file($this->phpbb_root_path . 'install'),
			);
			$checks_array = array_merge($checks_array, $custom_checks);
		}
		else
		{
			$checks_array = $custom_checks;
		}

		foreach ($checks_array as $message => $assertion)
		{
			$asserter->assert($assertion, $message);
		}

		return $asserter->get_failed_assertions();
	}

	function get_notices($custom_checks = array(), $only_custom_checks = false)
	{
		if (!class_exists('phpbb_assertion_manager'))
		{
			include($this->phpbb_root_path . 'includes/assertion_manager.' . $this->phpEx);
		}

		if (!class_exists('phpbb_ini_reader'))
		{
			include($this->phpbb_root_path . 'includes/ini_reader.' . $this->phpEx);
		}

		$asserter = new phpbb_assertion_manager;
		$php_ini = new phpbb_ini_reader;

		if (!$only_custom_checks)
		{
			$checks_array = array(
				'ERROR_SAFE_MODE'					=> !$php_ini->get_bool('safe_mode'),
				'ERROR_URL_FOPEN_SUPPORT'			=> $php_ini->get_bool('allow_url_fopen'),
				'ERROR_DIRECTORY_AVATARS_UNWRITABLE'=> phpbb_is_writable($this->phpbb_root_path . $this->config['avatar_path']),
				'ERROR_DIRECTORY_STORE_UNWRITABLE'	=> phpbb_is_writable($this->phpbb_root_path . 'store'),
				'ERROR_DIRECTORY_CACHE_UNWRITABLE'	=> phpbb_is_writable($this->phpbb_root_path . 'cache'),
				'ERROR_DIRECTORY_FILES_UNWRITABLE'	=> phpbb_is_writable($this->phpbb_root_path . $this->config['upload_path']),
				'ERROR_PCRE_UTF_SUPPORT'			=> preg_match('/\p{L}/u', 'a'),
				'ERROR_WRITABLE_CONFIG'				=> defined('PHPBB_DISABLE_CONFIG_CHECK') ||
														!file_exists($this->phpbb_root_path . 'config.' . $this->phpEx) ||
														!phpbb_is_writable($this->phpbb_root_path . 'config.' . $this->phpEx) ||
														!(@fileperms($this->phpbb_root_path . 'config.' . $this->phpEx) & 0x0002),
				'ERROR_PHP_VERSION_OLD'				=> !$this->auth->acl_get('a_server') || version_compare(PHP_VERSION, '5.2.0', '>='),
			);
		}
		else
		{
			$checks_array = $custom_checks;
		}

		foreach ($checks_array as $message => $assertion)
		{
			$asserter->assert($assertion, $message);
		}

		return $asserter->get_failed_assertions();
	}
}
