<?php
/**
*
* @package phpBB3
* @version $Id$
* @copyright (c) 2005 phpBB Group
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
* 
*
* @package phpBB3
*/
class phpbb_message
{
	const FLAG_BBCODE = 1;
	const FLAG_SMILIES = 2;
	const FLAG_LINKS = 4;
	const FLAG_ALL = 7;
	
	const POS_BBCODE = 0;
	const POS_SMILIES = 1;
	const POS_LINKS = 2;
	
	private $text;
	private $meta = '';
	private $flags = self::FLAG_ALL;
	
	private $column_prefix;
	
	public function __construct($text = '', $column_prefix = '')
	{
		$this->column_prefix = $column_prefix;
		
		if (is_array($text))
		{
			$this->text = $text[$this->column_prefix . '_text'];
			$this->meta = $text[$this->column_prefix . '_meta'];
			$this->flags = $text[$this->column_prefix . '_flags'];
		}
		else
		{
			$this->text = $text;
		}
	}
	
	public function text()
	{
		return $this->text;
	}
	
	public function set_text($text)
	{
		$this->text = (string) $text;
	}
	
	public function flags()
	{
		return $this->flags;
	}
	
	public function set_flags($flags)
	{
		$this->flags = (int) $flags;
	}
	
	public function allow_bbcode($state = null)
	{
		return $this->allow_helper(self::POS_BBCODE, $state);
	}
	
	public function allow_urls($state = null)
	{
		return $this->allow_helper(self::POS_LINKS, $state);
	}
	
	public function allow_smilies($state = null)
	{
		return $this->allow_helper(self::POS_SMILIES, $state);
	}
	
	public function allow_formatting($bbcode, $urls, $smilies)
	{
		$this->allow_bbcode($bbcode);
		$this->allow_urls($urls);
		$this->allow_smilies($smilies);
	}
	
	private function allow_helper($position, $state)
	{
		if (is_null($state))
		{
			return $position & $this->flags;
		}
		
		$this->set_flag($position, $state);
	}
	
	private function set_flag($position, $state)
	{
		$this->flags = ($state) ? $this->flags | (0x01 << $position) : $this->flags & ~(0x01 << $position);
	}
	
	public function store()
	{
		$parser = new phpbb_bbcode_parser;
		$this->meta = $parser->first_pass($this->text);
		
		return array(
			$this->column_prefix . '_text'	=> (string) $this->text,
			$this->column_prefix . '_meta'	=> (string) $this->meta,
			$this->column_prefix . '_flags'	=> (int) $this->flags,
		);
	}
	
	public function store_merge(&$row)
	{
		$row = array_merge($row, $this->store());
	}
	
	public function display()
	{
		$parser = new phpbb_bbcode_parser;
		$this->meta = $parser->first_pass($this->text);
		$parser->set_flags($this->flags);
		return $parser->second_pass($this->meta);
	}
	
	public function toString()
	{
		return $this->display();
	}
	
	public function decode()
	{
		return $this->text;
	}
	
	public function to_bbcode()
	{
		return $this->decode();
	}
}
