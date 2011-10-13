<?php
/**
*
* @package phpbb_passwordchecker
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

if (!function_exists('utf8_to_cp1252'))
{
	global $phpbb_root_path, $phpEx;
	include($phpbb_root_path . 'includes/utf/data/recode_basic.' . $phpEx);
}

class phpbb_passwordchecker_phpbb2 implements phpbb_passwordchecker_interface
{
	function check($row, $password_raw)
	{
		$password_old_format = (!STRIP) ? addslashes($password_raw) : $password_raw;

		// cp1252 is phpBB2's default encoding, characters outside ASCII range might work when converted into that encoding
		// plain md5 support left in for conversions from other systems.

		return (strlen($row['user_password']) == 34 && (phpbb_check_hash(md5($password_old_format), $row['user_password']) || phpbb_check_hash(md5(utf8_to_cp1252($password_old_format)), $row['user_password'])))
			|| (strlen($row['user_password']) == 32  && (md5($password_old_format) == $row['user_password'] || md5(utf8_to_cp1252($password_old_format)) == $row['user_password']));
	}
}
