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

use Asbo\WhosWhoBundle\Entity\Post as PostTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Post extends Units\Test
{

    public function testCreate()
    {
        $post = new PostTest;

        $this->variable($post->getId())->isNull();
        $this->variable($post->getName())->isNull();
        $this->variable($post->getType())->isNull();
        $this->variable($post->getDenier())->isNull();
        $this->variable($post->getMonogramme())->isNull();
    }

    public function testPost()
    {
        $post       = new PostTest;
        $name       = $this->faker->name();
        $denier     = $this->faker->randomNumber(0, 4);
        $type       = PostTest::TYPE_COMITE;
        $monogramme = 'XXX';

        $this->object($post->setName($name))->isIdenticalTo($post);
        $this->object($post->setDenier($denier))->isIdenticalTo($post);
        $this->object($post->setType($type))->isIdenticalTo($post);
        $this->object($post->setMonogramme($monogramme))->isIdenticalTo($post);

        $this->string($post->getName())->isEqualTo($name);
        $this->string($post->getMonogramme())->isEqualTo($monogramme);

        $this->integer($post->getDenier())->isEqualTo($denier);
        $this->integer($post->getType())->isEqualTo($type);

        $this->variable($post->setName(null)->getName())->isNull();
        $this->variable($post->setDenier(null)->getDenier())->isNull();
        $this->variable($post->setType(null)->getType())->isNull();
        $this->variable($post->setMonogramme(null)->getMonogramme())->isNull();
    }

    public function testToString()
    {
        $post = new PostTest;

        $this->castToString($post)
                ->isEqualTo('');

        $post->setName($name = $this->faker->name());

        $this->castToString($post)->isEqualTo($name);
    }

    public function testTypeList()
    {
        $post = new PostTest;
        $types = PostTest::getTypes();
        $this->array($types)->isNotEmpty();

        foreach ($types as $key => $val) {
            $this->integer($key);
            $this->string($val);

            $post = (new PostTest)->setType($key);
            $this->integer($post->getType())->isEqualTo($key);
            $this->string($post->getTypeCode())->isEqualTo($val);
        }
    }

    public function testCallback()
    {
        $types    = PostTest::getTypes();
        $callback = PostTest::getTypeCallbackValidation();

        $this->sizeOf($callback)->isEqualTo(count($types));
        $this->array($callback)->containsValues($types);
    }
}
