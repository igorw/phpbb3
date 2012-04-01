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
 * Extend the expression parser to convert L_* to lang.*
 */
class phpbb_twig_expression_parser extends Twig_ExpressionParser
{
    protected function createNameExpressionNode(Twig_Token $token)
    {
        $name = $token->getValue();

        if (preg_match('#^L_(\w+)$#', $name, $match))
        {
            $lang_key = $match[1];
            $lineno = $token->getLine();

            $node = new Twig_Node_Expression_Name('lang', $lineno);
            $arg = new Twig_Node_Expression_Constant($lang_key, $lineno);
            $arguments = new Twig_Node_Expression_Array(array(), $lineno);
            $type = Twig_TemplateInterface::ANY_CALL;

            return new Twig_Node_Expression_GetAttr($node, $arg, $arguments, $type, $lineno);
        }

        return parent::createNameExpressionNode($token);
    }
}
