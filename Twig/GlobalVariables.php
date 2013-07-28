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

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Global variables for AsboWhosWho package.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class GlobalVariables extends ContainerAware
{
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
