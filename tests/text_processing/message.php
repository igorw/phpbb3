<?php
/**
*
* @package testing
* @copyright (c) 2008 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once 'test_framework/framework.php';

require_once '../phpBB/includes/message_parser.php';
require_once '../phpBB/includes/message.php';

class phpbb_text_processing_message_test extends phpbb_test_case
{
	public function test_flags()
	{
		$message = new phpbb_message();
		
		$this->assertEquals(
			phpbb_message::FLAG_ALL,
			$message->flags(),
			'Initial flag state'
		);
		
		$message->allow_bbcode(false);
		$this->assertEquals(
			phpbb_message::FLAG_SMILIES | phpbb_message::FLAG_LINKS,
			$message->flags(),
			'Disable bbcode'
		);
		
		$message->allow_smilies(false);
		$this->assertEquals(
			phpbb_message::FLAG_LINKS,
			$message->flags(),
			'Disable smilies'
		);
		
		$message->allow_bbcode(true);
		$this->assertEquals(
			phpbb_message::FLAG_LINKS | phpbb_message::FLAG_BBCODE,
			$message->flags(),
			'Re-enable bbcode'
		);
	}

}

