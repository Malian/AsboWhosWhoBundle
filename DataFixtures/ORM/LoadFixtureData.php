<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Nelmio\Alice\Fixtures;

class LoadFixtureData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $om)
    {
        $kernel = $this->container->get('kernel');
        $path   = $kernel->locateResource('@AsboWhosWhoBundle/DataFixtures/ORM/fixtures.yml');

        Fixtures::load($path, $om, array('providers' => array($this)));
    }

    public function monogramme()
    {
        $monogrammes = array(
            'X',
            'XX',
            'XXX',
            'XXXX',
            'XXXXX',
            'TM',
            'SB',
            'CP',
            'SC',
            'SX',
            'PC',
            'CB',
            'AP',
            'PM',
            'VS',
            'VX',
            'VXX',
            'VXXX',
            'VXXXX',
            'VXXXXX',
        );

        return $monogrammes[array_rand($monogrammes)];
    }
}
