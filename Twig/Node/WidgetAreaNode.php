<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Node;

class WidgetAreaNode extends \Twig_Node
{
    public function __construct($area, $strategy, $lineno, $tag = null)
    {
        parent::__construct(array(), array('area' => $area, 'strategy' => $strategy), $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('echo $this->env->getExtension(\'http_kernel\')->renderFragmentStrategy(\'' . $this->getAttribute('strategy') . '\',')
            ->write('    $this->env->getExtension(\'http_kernel\')')
            ->write('         ->controller(\'IsometriksSymEditBundle:Widget:renderArea\', array(')
            ->write('             \'area\' => \'' . $this->getAttribute('area') . '\',')
            ->write('             \'path\' => $context[\'Page\']->getPath(),')
            ->write('             \'_page_id\'   => is_numeric($context[\'Page\']->getId()) ? $context[\'Page\']->getId() : \'\',')
            ->write('         ))')
            ->write('    );');
    }
}