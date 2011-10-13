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

/**
* An interface defining a password checker.
*
* Password checkers test a plaintext password
* against a hash.
*
* @package phpbb_passwordchecker
*/
interface phpbb_passwordchecker_interface
{
	function check($row, $password_raw);
}
