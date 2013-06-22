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

use Asbo\WhosWhoBundle\Entity\Family as BaseFamily;
use Asbo\WhosWhoBundle\Tests\Units;

class Family extends Units\Test
{

    public function testCreate()
    {
        $family = new BaseFamily;

        $this->variable($family->getId())->isNull();
        $this->variable($family->getFirstname())->isNull();
        $this->variable($family->getLastname())->isNull();
        $this->variable($family->getDate())->isNull();
        $this->variable($family->getType())->isNull();
        $this->variable($family->getFra())->isNull();
        $this->variable($family->getLink())->isNull();
        $this->boolean($family->isValid())->isFalse();
    }

    public function testSetttersAndGetters()
    {
        $family = new BaseFamily;

        $firstname = $this->faker->firstname();
        $lastname  = $this->faker->lastname();
        $date      = $this->faker->dateTimeBetween('-30 years', 'now');
        $type      = array_rand(BaseFamily::getTypes());

        $this->object($family->setFirstname($firstname))->isIdenticalTo($family);
        $this->object($family->setLastname($lastname))->isIdenticalTo($family);
        $this->object($family->setDate($date))->isIdenticalTo($family);
        $this->object($family->setType($type))->isIdenticalTo($family);

        $this->integer($family->getType())->isEqualTo($type);

        $this->string($family->getFirstname())->isEqualTo($firstname);
        $this->string($family->getLastname())->isEqualTo($lastname);

        $this->datetime($family->getDate())->isEqualTo($date);

        $this->variable($family->setFirstname(null)->getFirstname())->isNull();
        $this->variable($family->setLastname(null)->getLastname())->isNull();
        $this->variable($family->setDate(null)->getDate())->isNull();
        $this->variable($family->setType(null)->getType())->isNull();
        $this->variable($family->setLink(null)->getLink())->isNull();
    }

    public function testToString()
    {
        $family    = new BaseFamily;

        $this->castToString($family)
                ->isEqualTo(' ');

        $firstname = $this->faker->firstname;
        $lastname  = $this->faker->lastname;

        $family->setFirstname($firstname)->setLastname($lastname);

        $this->castToString($family)->isEqualTo($firstname . ' ' . $lastname);
    }

    public function testTypes()
    {
        $this->array($types = BaseFamily::getTypes())->hasSize(5);

        foreach ($types as $key => $val) {

            $this->integer($key);
            $this->string($val);

            $family = (new BaseFamily)->setType($key);
            $this->integer($family->getType())->isEqualTo($key);
            $this->string($family->getTypeCode())->isEqualTo($val);
        }
    }

    public function testFra()
    {
        $family = new BaseFamily;
        $fra   = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = 140);
        $this->object($family->setFra($fra))->isIdenticalTo($family);
        $this->object($family->getFra())->isIdenticalTo($fra);
        $this->integer($family->getFra()->getId())->isEqualTo($id);
    }

    public function testCallback()
    {
        $types    = BaseFamily::getTypes();
        $callback = BaseFamily::getTypeCallbackValidation();

        $this->sizeOf($callback)->isEqualTo(count($types));
        $this->array($callback)->containsValues($types);
    }

    public function testLink()
    {
        $link = $this->createLinkMock(
            $this->faker->randomDigit(),
            $firstname = $this->faker->firstname(),
            $lastname = $this->faker->lastname()
        );

        $family = new BaseFamily;

        $this->object($family->setLink($link))->isIdenticalTo($family);
        $this->object($family->getLink())->isIdenticalTo($link);

        $this->castToString($family)->isEqualTo($firstname. ' ' .$lastname);

        $this->string($family->getFirstname())->isEqualTo($firstname);
        $this->string($family->getLastname())->isEqualTo($lastname);

        $this->boolean($family->isValid())->isTrue();
    }

    public function testIsValid()
    {
        $family = new BaseFamily;

        $this->boolean($family->isValid())->isFalse();

        $family->setFirstname($this->faker->firstname());

        $this->boolean($family->isValid())->isFalse();

        $family->setLastname($this->faker->lastname());

        $this->boolean($family->isValid())->isTrue();
    }

    protected function createLinkMock($id, $firstname = null, $lastname = null)
    {
        $fra                               = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($fra)->getId        = $id;
        $this->calling($fra)->getFirstname = $firstname;
        $this->calling($fra)->getLastname  = $lastname;
        $this->calling($fra)->__toString  =  $firstname.' '.$lastname;

        return $fra;
    }
}
