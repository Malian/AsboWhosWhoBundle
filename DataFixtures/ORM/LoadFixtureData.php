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
use Nelmio\Alice\Fixtures;

class LoadFixtureData implements FixtureInterface
{

    public function load(ObjectManager $om)
    {
        Fixtures::load(__DIR__.'/fixtures.yml', $om, array('providers' => array($this)));
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
