<?php
/**
*
* @package phpBB3
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
 */
class phpbb_twig_lexer extends Twig_Lexer
{
    private $lower_tokens = array(
        'EXTENDS',
        'BLOCK',
        'ENDBLOCK',
        'IF',
        'ENDIF',
        'ELSE',
        'ELSEIF',
        'INCLUDE',
        'FOR',
        'ENDFOR',
    );

    protected function pushToken($type, $value = '')
    {
        if (Twig_Token::NAME_TYPE === $type && in_array($value, $this->lower_tokens)) {
            $value = strtolower($value);
        }

        parent::pushToken($type, $value);
    }
}
