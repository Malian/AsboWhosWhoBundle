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

use Asbo\WhosWhoBundle\Entity\Address as AddressTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Address extends Units\Test
{

    public function testCreate()
    {
        $address = new AddressTest;

        $this->variable($address->getId())->isNull();
        $this->variable($address->getAddress())->isNull();
        $this->variable($address->getLocality())->isNull();
        $this->variable($address->getCountry())->isNull();
        $this->variable($address->getLng())->isNull();
        $this->variable($address->getLat())->isNull();
        $this->variable($address->getFra())->isNull();
        $this->variable($address->getType())->isEqualTo(AddressTest::TYPE_AUTRE);
        $this->boolean($address->isPrincipal())->isFalse();
    }

    public function testAddress()
    {
        $object    = new AddressTest;
        $address   = $this->faker->address();
        $country   = $this->faker->country();
        $latitude  = $this->faker->latitude();
        $longitude = $this->faker->longitude();
        $locality  = $this->faker->city();

        $this->object($object->setAddress($address))->isIdenticalTo($object);
        $this->object($object->setCountry($country))->isIdenticalTo($object);
        $this->object($object->setLat($latitude))->isIdenticalTo($object);
        $this->object($object->setLng($longitude))->isIdenticalTo($object);
        $this->object($object->setLocality($locality))->isIdenticalTo($object);

        $this->string($object->getAddress())->isEqualTo($address);
        $this->string($object->getCountry())->isEqualTo($country);
        $this->string($object->getLocality())->isEqualTo($locality);

        $this->float($object->getLat())->isEqualTo((float) $latitude);
        $this->float($object->getLng())->isEqualTo((float) $longitude);
        $this->float($object->setLat((float) $latitude)->getLat())->isEqualTo((float) $latitude);
        $this->float($object->setLng((float) $longitude)->getLng())->isEqualTo((float) $longitude);

        $this->variable($object->setAddress(null)->getAddress())->isNull();
        $this->variable($object->setCountry(null)->getCountry())->isNull();
        $this->variable($object->setLat(null)->getLat())->isNull();
        $this->variable($object->setLng(null)->getLng())->isNull();
        $this->variable($object->setLocality(null)->getLocality())->isNull();
    }

    public function testToString()
    {
        $address = new AddressTest;
        $this->castToString($address)
                ->isEqualTo('');

        $val     = $this->faker->address();
        $address->setAddress($val);
        $this->castToString($address)->isEqualTo($val);
    }

    public function testTypeList()
    {
        $address = new AddressTest;
        $types   = AddressTest::getTypes();
        $this->array($types)->isNotEmpty();

        foreach ($types as $key => $val) {
            $this->integer($key);
            $this->string($val);

            $address = (new AddressTest)->setType($key);
            $this->integer($address->getType())->isEqualTo($key);
            $this->string($address->getTypeCode())->isEqualTo($val);
        }
    }

    public function testCallback()
    {
        $types    = AddressTest::getTypes();
        $callback = AddressTest::getTypeCallbackValidation();

        $this->sizeOf($callback)->isEqualTo(count($types));
        $this->array($callback)->containsValues($types);
    }

    public function testPrincipal()
    {
        $address = new AddressTest;

        $address->setPrincipal(true);
        $this->boolean($address->isPrincipal())->isTrue();

        $address->setPrincipal(false);
        $this->boolean($address->isPrincipal())->isFalse();
    }

    public function testFra()
    {
        $address = new AddressTest;
        $fra   = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = 140);
        $this->object($address->setFra($fra))->isIdenticalTo($address);
        $this->object($address->getFra())->isIdenticalTo($fra);
        $this->integer($address->getFra()->getId())->isEqualTo($id);
    }
}
