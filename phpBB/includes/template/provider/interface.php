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
* Provides a template locator with paths
*
* Finds installed template paths and makes them available to the locator.
*
* @package phpBB3
*/
interface phpbb_template_provider_interface extends IteratorAggregate
{
    /**
    * Defines a prefix to use for template paths in extensions
    *
    * @param string $ext_dir_prefix The prefix including trailing slash
    * @return null
    */
    function set_ext_dir_prefix($ext_dir_prefix);

    /**
    * Finds template paths using the extension manager
    *
    * Finds paths with the same name (e.g. styles/prosilver/template/) in all
    * active extensions. Then appends the actual template paths based in the
    * current working directory.
    *
    * @return array     List of template paths
    */
    function find();

    /**
    * Overwrites the current template names and paths
    *
    * @param array $templates An associative map from template names to paths.
    *                         The first element is the main template.
    *                         If the path is false, it will be generated from
    *                         the supplied name.
    * @return null
    */
    function set_templates(array $templates);

    /**
    * Retrieves the path to the main template passed into set_templates()
    *
    * @return string Main template path
    */
    function get_main_template_path();
}
