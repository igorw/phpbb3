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
 * Convert var nodes from L_* to lang.*
 */
class phpbb_twig_node_visitor implements Twig_NodeVisitorInterface
{
    public function enterNode(Twig_NodeInterface $node, Twig_Environment $env)
    {
        return $node;
    }

    public function leaveNode(Twig_NodeInterface $node, Twig_Environment $env)
    {
        if ($node instanceof Twig_Node_Expression_Name)
        {
            $name = $node->getAttribute('name');
            $lineno = $node->getLine();

            if (preg_match('#^L_(\w+)$#', $name, $match))
            {
                $lang_key = $match[1];

                // try $lang_key
                // if that fails, try $lang[$lang_key]
                // if that fails, '{ $lang_key }'

                $lang_node = new Twig_Node_Expression_GetAttr(
                    new Twig_Node_Expression_Name('lang', $lineno),
                    new Twig_Node_Expression_Constant($lang_key, $lineno),
                    new Twig_Node_Expression_Array(array(), $lineno),
                    Twig_TemplateInterface::ANY_CALL,
                    $lineno
                );

                $filter_node = $this->createDefaultFilterNode($node, $lang_node, $lineno);

                $lang_key_node = new Twig_Node_Expression_Constant('{ '.$lang_key.' }', $lineno);
                $filter_node = $this->createDefaultFilterNode($filter_node, $lang_key_node, $lineno);

                return $filter_node;
            }
        }

        return $node;
    }

    public function getPriority()
    {
        return 0;
    }

    private function createDefaultFilterNode($node, $default_node, $lineno)
    {
        return new Twig_Node_Expression_Filter_Default(
            $node,
            new Twig_Node_Expression_Constant('default', $lineno),
            new Twig_Node(array($default_node), array(), $lineno),
            $lineno
        );
    }
}
