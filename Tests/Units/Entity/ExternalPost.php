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

use Asbo\WhosWhoBundle\Entity\ExternalPost as ExternalPostTest;
use Asbo\WhosWhoBundle\Tests\Units;

class ExternalPost extends Units\Test
{

    public function testCreate()
    {
        $post = new ExternalPostTest;

        $this->variable($post->getId())->isNull();
        $this->variable($post->getWhere())->isNull();
        $this->variable($post->getPosition())->isNull();
        $this->variable($post->getDateBegin())->isNull();
        $this->variable($post->getDateEnd())->isNull();
        $this->variable($post->getFra())->isNull();
        $this->boolean($post->isCurrent())->isTrue();
    }

    public function testExternalPost()
    {
        $post      = new ExternalPostTest;
        $where     = $this->faker->company();
        $position  = $this->faker->catchPhrase();
        $dateBegin = $this->faker->dateTimeBetween('-30 years', 'now');
        $dateEnd   = $this->faker->dateTimeBetween($dateBegin, 'now');

        $this->object($post->setWhere($where))->isIdenticalTo($post);
        $this->object($post->setPosition($position))->isIdenticalTo($post);
        $this->object($post->setDateBegin($dateBegin))->isIdenticalTo($post);
        $this->object($post->setDateEnd($dateEnd))->isIdenticalTo($post);

        $this->string($post->getWhere())->isEqualTo($where);
        $this->string($post->getPosition())->isEqualTo($position);
        $this->datetime($post->getDateBegin())->isEqualTo($dateBegin);
        $this->datetime($post->getDateEnd())->isEqualTo($dateEnd);
        $this->boolean($post->isCurrent())->isFalse();

        $this->variable($post->setWhere(null)->getWhere())->isNull();
        $this->variable($post->setPosition(null)->getPosition())->isNull();
        $this->variable($post->setDateBegin(null)->getDateBegin())->isNull();
        $this->variable($post->setDateEnd(null)->getDateEnd())->isNull();

        $this->boolean($post->isCurrent())->isTrue();
    }

    public function testToString()
    {
        $post = new ExternalPostTest;

        $this->castToString($post)
                ->isEqualTo(' in ');

        $post->setPosition($position = $this->faker->catchPhrase())
             ->setWhere($where = $this->faker->company());

        $this->castToString($post)->isEqualTo($position. ' in ' .$where);
    }

    public function testFra()
    {
        $post = new ExternalPostTest;
        $fra  = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = $this->faker->randomDigitNotNull());
        $this->object($post->setFra($fra))->isIdenticalTo($post);
        $this->object($post->getFra())->isIdenticalTo($fra);
        $this->integer($post->getFra()->getId())->isEqualTo($id);
    }

    public function testIsDateBeginLessThanDateEnd()
    {
        $post = (new ExternalPostTest)->setDateBegin($dateBegin = $this->faker->dateTimeBetween('-30 years', 'now'))
                             ->setDateEnd($this->faker->dateTimeBetween($dateBegin, 'now'));

        $this->boolean($post->isDateBeginLessThanDateEnd())->isTrue();

        $post = (new ExternalPostTest)->setDateBegin($dateBegin = $this->faker->dateTimeBetween('-30 years', 'now'))
                             ->setDateEnd($this->faker->dateTimeBetween('-50 years', $dateBegin));

        $this->boolean($post->isDateBeginLessThanDateEnd())->isFalse();
    }
}
