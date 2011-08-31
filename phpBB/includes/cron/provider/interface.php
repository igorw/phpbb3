<?php
/**
*
* @package phpBB3
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
* Provides cron manager with tasks
*
* Finds installed cron tasks and makes them available to the cron manager.
*
* @package phpBB3
*/
interface phpbb_cron_provider_interface extends IteratorAggregate
{
    /**
    * Finds template paths using the extension manager.
    *
    * @return array     List of task names
    */
    function find();
}
