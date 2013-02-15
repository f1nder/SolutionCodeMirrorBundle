<?php

namespace Solution\CodeMirrorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('solution_code_mirror');

        $rootNode
            ->children()
              ->scalarNode('form_type')->defaultValue('Solution\CodeMirrorBundle\Form\Type\CodeMirrorType')->end()
              ->scalarNode('twig_extension')->defaultValue('Solution\CodeMirrorBundle\Twig\CodeMirrorExtension')->end()
              ->arrayNode('parameters')
                ->prototype('scalar')->end()
              ->end()
              ->arrayNode('mode_dirs')->isRequired()
                ->requiresAtLeastOneElement()
                ->prototype('scalar')->end()
              ->end()
              ->arrayNode('themes_dirs')->isRequired()
                ->requiresAtLeastOneElement()
                 ->prototype('scalar')->end()
              ->end()
            ->end();
        return $treeBuilder;
    }
}
