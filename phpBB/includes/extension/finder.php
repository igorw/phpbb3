<?php
/**
*
* @package extension
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
* The extension finder provides a simple way to locate files in active extensions
*
* @package extension
*/
class phpbb_extension_finder
{
	protected $extension_manager;
	protected $phpbb_root_path;
	protected $cache;
	protected $phpEx;
	protected $cache_name;

	/**
	* @var	array	An associative array, containing all search parameters set in
	*				methods
	*/
	protected $query;

	/**
	* @var	array	A map from md5 hashes of serialized queries to their
	*				previously retrieved results.
	*/
	protected $cached_queries;

	/**
	* Creates a new finder instance with its dependencies
	*
	* @param phpbb_extension_manager $extension_manager An extension manager
	*            instance that provides the finder with a list of active
	*            extensions and their locations
	* @param string $phpbb_root_path Path to the phpbb root directory
	* @param phpbb_cache_driver_interface $cache A cache instance or null
	* @param string $phpEx php file extension
	* @param string $cache_name The name of the cache variable, defaults to
	*                           _ext_finder
	*/
	public function __construct(phpbb_extension_manager $extension_manager, $phpbb_root_path = '', phpbb_cache_driver_interface $cache = null, $phpEx = '.php', $cache_name = '_ext_finder')
	{
		$this->extension_manager = $extension_manager;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->cache = $cache;
		$this->phpEx = $phpEx;
		$this->cache_name = $cache_name;

		$this->query = array(
			'default_path' => false,
			'default_suffix' => false,
			'default_prefix' => false,
			'default_directory' => false,
			'suffix' => false,
			'prefix' => false,
			'directory' => false,
		);

		$this->cached_queries = ($this->cache) ? $this->cache->get($this->cache_name) : false;
	}

	/**
	* Sets a default path to be searched in addition to extensions
	*
	* @param string $default_path The path relative to /
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function default_path($default_path)
	{
		$this->query['default_path'] = $default_path;
		return $this;
	}

	/**
	* Sets a suffix all files found in extensions must match
	*
	* Automatically sets the default_suffix if its value does not differ from
	* the current suffix.
	*
	* @param string $suffix A filename suffix
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function suffix($suffix)
	{
		if ($this->query['default_suffix'] === $this->query['suffix'])
		{
			$this->query['default_suffix'] = $suffix;
		}

		$this->query['suffix'] = $suffix;
		return $this;
	}

	/**
	* Sets a suffix all files found in the default path must match
	*
	* @param string $default_suffix A filename suffix
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function default_suffix($default_suffix)
	{
		$this->query['default_suffix'] = $default_suffix;
		return $this;
	}

	/**
	* Sets a prefix all files found in extensions must match
	*
	* Automatically sets the default_prefix if its value does not differ from
	* the current prefix.
	*
	* @param string $prefix A filename prefix
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function prefix($prefix)
	{
		if ($this->query['default_prefix'] === $this->query['prefix'])
		{
			$this->query['default_prefix'] = $prefix;
		}

		$this->query['prefix'] = $prefix;
		return $this;
	}

	/**
	* Sets a prefix all files found in the default path must match
	*
	* @param string $default_prefix A filename prefix
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function default_prefix($default_prefix)
	{
		$this->query['default_prefix'] = $default_prefix;
		return $this;
	}

	/**
	* Sets a directory all files found in extensions must be contained in
	*
	* Automatically sets the default_directory if its value does not differ from
	* the current directory.
	*
	* @param string $directory
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function directory($directory)
	{
		if (strlen($directory) > 1 && $directory[strlen($directory) - 1] === '/')
		{
			$directory = substr($directory, 0, -1);
		}

		if ($this->query['default_directory'] === $this->query['directory'])
		{
			$this->query['default_directory'] = $directory;
		}

		$this->query['directory'] = $directory;
		return $this;
	}

	/**
	* Sets a directory all files found in the default path must be contained in
	*
	* @param string $default_directory
	* @return phpbb_extension_finder This object for chaining calls
	*/
	public function default_directory($default_directory)
	{
		if (strlen($default_directory) > 1 && $default_directory[strlen($default_directory) - 1] === '/')
		{
			$default_directory = substr($default_directory, 0, -1);
		}

		$this->query['default_directory'] = $default_directory;
		return $this;
	}

	/**
	* Finds auto loadable php classes matching the configured options.
	*
	* The php file extension is automatically added to suffixes.
	*
	* @param bool $cache Whether the result should be cached
	* @return array An array of found class names
	*/
	public function get_classes($cache = true)
	{
		$this->query['suffix'] .= $this->phpEx;
		$this->query['default_suffix'] .= $this->phpEx;

		$files = $this->get_files($cache);

		$classes = array();
		foreach ($files as $file)
		{
			$file = preg_replace('#^includes/#', '', $file);

			$classes[] = 'phpbb_' . str_replace('/', '_', substr($file, 0, -strlen($this->phpEx)));
		}
		return $classes;
	}

	/**
	* Finds all directories matching the configured options
	*
	* @param bool $cache Whether the result should be cached
	* @return array An array of paths to found directories
	*/
	public function get_directories($cache = true)
	{
		return $this->find($cache, true);
	}

	/**
	* Finds all files matching the configured options.
	*
	* @param bool $cache Whether the result should be cached
	* @return array An array of paths to found files
	*/
	public function get_files($cache = true)
	{
		return $this->find($cache, false);
	}

	/**
	* Finds all file system entries matching the configured options
	*
	* @param bool $cache Whether the result should be cached
	* @param bool $is_dir Whether the found items should be directories
	* @return array An array of paths to found items
	*/
	protected function find($cache = true, $is_dir = false)
	{
		$this->query['is_dir'] = $is_dir;
		$query = md5(serialize($this->query));

		if (!defined('DEBUG') && $cache && isset($this->cached_queries[$query]))
		{
			return $this->cached_queries[$query];
		}

		$files = array();

		$extensions = $this->extension_manager->all_enabled();

		if ($this->query['default_path'])
		{
			$extensions['/'] = $this->phpbb_root_path . $this->query['default_path'];
		}

		foreach ($extensions as $name => $path)
		{
			if (!file_exists($path))
			{
				continue;
			}

			if ($name === '/')
			{
				$location = $this->query['default_path'];
				$name = '';
				$suffix = $this->query['default_suffix'];
				$prefix = $this->query['default_prefix'];
				$directory = $this->query['default_directory'];
			}
			else
			{
				$location = 'ext/';
				$name .= '/';
				$suffix = $this->query['suffix'];
				$prefix = $this->query['prefix'];
				$directory = $this->query['directory'];
			}

			// match only first directory if leading slash is given
			if ($directory === '/')
			{
				$directory_pattern = '^' . preg_quote(DIRECTORY_SEPARATOR, '#');
			}
			else if ($directory && $directory[0] === '/')
			{
				$directory_pattern = '^' . preg_quote($directory . DIRECTORY_SEPARATOR, '#');
			}
			else
			{
				$directory_pattern = preg_quote(DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR, '#');
			}
			$directory_pattern = '#' . $directory_pattern . '#';

			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
			foreach ($iterator as $file_info)
			{
				if ($file_info->isDir() == $is_dir)
				{
					$relative_path = ($is_dir) ? $iterator->getInnerIterator()->getSubPath() . DIRECTORY_SEPARATOR:
						$iterator->getInnerIterator()->getSubPathname();

					$item_name = ($is_dir) ? basename($iterator->getInnerIterator()->getSubPath()) :
						$file_info->getFilename();

					if ((!$suffix || substr($relative_path, -strlen($suffix)) === $suffix) &&
						(!$prefix || substr($item_name, 0, strlen($prefix)) === $prefix) &&
						(!$directory || preg_match($directory_pattern, DIRECTORY_SEPARATOR . $relative_path)))
					{
						$files[] = str_replace(DIRECTORY_SEPARATOR, '/', $location . $name . $relative_path);
					}
				}
			}
		}

		if ($cache && $this->cache)
		{
			$this->cached_queries[$query] = $files;
			$this->cache->put($this->cache_name, $this->cached_queries);
		}

		return $files;
	}
}
