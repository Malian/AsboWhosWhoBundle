<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * AsboWhosWhoExtension.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('asbo_whos_who');

        $rootNode->children()
                    ->arrayNode('redirect_profile_user')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('enabled')
                                ->defaultTrue()
                            ->end()
                            ->scalarNode('route')
                                ->cannotBeEmpty()
                                ->defaultValue('sonata_user_profile_show')
                            ->end()
                            ->scalarNode('new')
                                ->cannotBeEmpty()
                                ->defaultValue('asbo_whoswho_fra_show')
                            ->end()
                            ->scalarNode('listener')
                                ->cannotBeEmpty()
                                ->defaultValue('Asbo\WhosWhoBundle\EventListener\ProfileListener')
                            ->end()
                        ->end()
                    ->end()
                    ->booleanNode('test')
                        ->defaultValue(false)
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
