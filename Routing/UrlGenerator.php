<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Url generator for Asbo WhosWho namespace
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class UrlGenerator
{
    /**
     * Router
     *
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private $generator;

    /**
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generate an standart url
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     */
    public function generate($name, $parameters = [], $absolute = false)
    {
        return $this->generator->generate($name, $parameters, $absolute);
    }

    /**
     * Generate an url to a fra
     *
     * @param \Asbho\WhosWhoBundle\Entity\Fra $fra
     */
    public function fra(Fra $fra, $absolute = false)
    {
        return $this->generate('asbo_whoswho_fra_show', ['slug' => $fra->getSlug()], $absolute);
    }

    /**
     * Generate an url to edit a fra
     *
     * @param \Asbho\WhosWhoBundle\Entity\Fra $fra
     */
    public function editFra(Fra $fra, $absolute = false)
    {
        return $this->generate('asbo_whoswho_fra_edit', ['slug' => $fra->getSlug()], $absolute);
    }
}
