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

use Asbo\WhosWhoBundle\Entity\Phone as PhoneTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Phone extends Units\Test
{

    public function testCreate()
    {
        $this->if($phone = new PhoneTest)
             ->then
                ->variable($phone->getId())->isNull()
                ->variable($phone->getNumber())->isNull()
                ->variable($phone->getFra())->isNull()
                ->variable($phone->getType())->isEqualTo(PhoneTest::TYPE_PRIVEE)
                ->boolean($phone->isPrincipal())->isFalse()
             ->if($phone->setNumber($val = uniqid()))
             ->then
                ->string($phone->getNumber())
                    ->isEqualTo($val);
    }

    public function testPhone()
    {
        $this->if($phone = new PhoneTest())
             ->then
                ->object($phone->setNumber($val = uniqid()))->isIdenticalTo($phone)
                ->string($phone->getNumber())->isEqualTo($val);
    }

    public function testCountry()
    {
        $phone = new PhoneTest;
        $val   = 'BE';

        $this->object($phone->setCountry($val))->isIdenticalTo($phone);
        $this->string($phone->getCountry())->isEqualTo($val);
    }

    public function testToString()
    {
        $phone = new PhoneTest;

        $this->castToString($phone)
                ->isEqualTo('');

        $phone->setNumber($val = uniqid());
        $this->castToString($phone)->isEqualTo($val);
    }

    public function testTypeList()
    {
        $phone = new PhoneTest;
        $types = PhoneTest::getTypes();
        $this->array($types)->isNotEmpty();

        foreach ($types as $key => $val) {
            $this->integer($key);
            $this->string($val);

            $phone = (new PhoneTest)->setType($key);
            $this->integer($phone->getType())->isEqualTo($key);
            $this->string($phone->getTypeCode())->isEqualTo($val);
        }
    }

    public function testCallback()
    {
        $types    = PhoneTest::getTypes();
        $callback = PhoneTest::getTypeCallbackValidation();

        $this->sizeOf($callback)->isEqualTo(count($types));
        $this->array($callback)->containsValues($types);
    }

    public function testPrincipal()
    {
        $phone = new PhoneTest;

        $phone->setPrincipal(true);
        $this->boolean($phone->isPrincipal())->isTrue();

        $phone->setPrincipal(false);
        $this->boolean($phone->isPrincipal())->isFalse();
    }

    public function testFra()
    {
        $phone = new PhoneTest;
        $fra   = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = 140);
        $this->object($phone->setFra($fra))->isIdenticalTo($phone);
        $this->object($phone->getFra())->isIdenticalTo($fra);
        $this->integer($phone->getFra()->getId())->isEqualTo($id);
    }
}
