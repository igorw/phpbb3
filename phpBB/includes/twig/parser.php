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
 * Extend the twig parser to use a custom expression parser
 */
class phpbb_twig_parser extends Twig_Parser
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->expressionParser = new phpbb_twig_expression_parser($this, $this->env->getUnaryOperators(), $this->env->getBinaryOperators());
    }
}
