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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * AsboWhosWhoExtension.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AsboWhosWhoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('controller.xml');

        if (false === $config['test']) {
            $loader->load('admin.xml');
        }

        $loader->load('form_types.xml');
        $loader->load('twig.xml');
        $loader->load('util.xml');
        $loader->load('validators.xml');
        $loader->load('orm.xml');

        if ($config['redirect_profile_user']['enabled']) {
            $container->setParameter('asbo_whoswho.profile.listener.route', $config['redirect_profile_user']['route']);
            $container->setParameter('asbo_whoswho.profile.listener.class', $config['redirect_profile_user']['listener']);
            $loader->load('redirect.xml');
        }
    }
}
