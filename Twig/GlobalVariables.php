<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Global variables for AsboWhosWho package.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class GlobalVariables
{
    /**
     * Container
     *
     * @var \Symfony\Compopent\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return asbo.whoswho.version parameter
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->container->getParameter('asbo.whoswho.version');
    }

    /**
     * Return the url generator from Asbo WhosWho namespace
     *
     * @return \Asbo\WhosWhoBundle\Routing\UrlGenerator
     */
    public function getUrlGenerator()
    {
        return $this->container->get('asbo_whoswho.routing.urlGenerator');
    }
}
