<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Entity;

use Asbo\WhosWhoBundle\Entity\Rank as RankTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Rank extends Units\Test
{

    public function testCreate()
    {
        $rank = new RankTest;

        $this->variable($rank->getId())->isNull();
        $this->variable($rank->getName())->isNull();
        $this->variable($rank->getFra())->isNull();
    }

    public function testRank()
    {
        $rank = new RankTest;
        $name = $this->faker->sentence();

        $this->object($rank->setName($name))->isIdenticalTo($rank);
        $this->string($rank->getName())->isEqualTo($name);
    }

    public function testToString()
    {
        $rank = new RankTest;

        $this->castToString($rank)
                ->isEqualTo('');

        $rank->setName($name = $this->faker->sentence());

        $this->castToString($rank)->isEqualTo($name);
    }

    public function testFra()
    {
        $rank = new RankTest;
        $fra  = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = $this->faker->randomDigitNotNull());
        $this->object($rank->setFra($fra))->isIdenticalTo($rank);
        $this->object($rank->getFra())->isIdenticalTo($fra);
        $this->integer($rank->getFra()->getId())->isEqualTo($id);
    }
}
