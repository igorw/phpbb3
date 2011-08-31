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
class phpbb_cron_provider_extension implements phpbb_cron_provider_interface
{
	/**
	* Array holding all found items
	* @var array
	*/
	protected $items = array();

	/**
	* An extension manager to search for items in extensions
	* @var phpbb_extension_manager
	*/
	protected $extension_manager;

	/**
	* Constructor. Loads all available items.
	*
	* @param phpbb_extension_manager $extension_manager phpBB extension manager
	*/
	public function __construct(phpbb_extension_manager $extension_manager)
	{
		$this->extension_manager = $extension_manager;

		$this->items = $this->find();
	}

	/**
	* Finds cron task names using the extension manager.
	*
	* All PHP files in includes/cron/task/core/ are considered tasks. Tasks
	* in extensions have to be located in a directory called cron or a subdir
	* of a directory called cron. The class and filename must end in a _task
	* suffix. Additionally all PHP files in includes/cron/task/core/ are
	* tasks.
	*
	* @return array     List of task names
	*/
	public function find()
	{
		$finder = $this->extension_manager->get_finder();

		return $finder
			->suffix('_task')
			->directory('/cron')
			->default_path('includes/cron/task/core/')
			->default_suffix('')
			->default_directory('')
			->get_classes();
	}

	/**
	* Retrieve an iterator over all items
	*
	* @return ArrayIterator An iterator for the array of template paths
	*/
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
}
