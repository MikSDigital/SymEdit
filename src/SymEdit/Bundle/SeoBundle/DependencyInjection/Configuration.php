<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('symedit_seo');

        $rootNode
            ->children()
                ->booleanNode('annotations')
                    ->info('Whether or not to load the annotation subscriber')
                    ->defaultFalse()
                ->end()
                ->arrayNode('limit')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('title')->defaultValue(65)->end()
                        ->integerNode('description')->defaultValue(155)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
