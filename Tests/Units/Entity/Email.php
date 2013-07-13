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

use Asbo\WhosWhoBundle\Entity\Email as EmailTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Email extends Units\Test
{

    public function testCreate()
    {
        $email = new EmailTest;

        $this->variable($email->getId())->isNull();
        $this->variable($email->getEmail())->isNull();
        $this->variable($email->getFra())->isNull();
        $this->variable($email->getType())->isEqualTo(EmailTest::TYPE_AUTRE);
    }

    public function testEmail()
    {
        $email = new EmailTest;
        $val   = $this->faker->email();

        $this->object($email->setEmail($val))->isIdenticalTo($email);
        $this->string($email->getEmail())->isEqualTo($val);
        $this->variable($email->setEmail(null)->getEmail())->isNull();
    }

    public function testToString()
    {
        $email = new EmailTest;
        $this->castToString($email)
                ->isEqualTo('');

        $val = $this->faker->email();
        $email->setEmail($val);
        $this->castToString($email)->isEqualTo($val);
    }

    public function testTypeList()
    {
        $email = new EmailTest;
        $types = EmailTest::getTypes();
        $this->array($types)->isNotEmpty();

        foreach ($types as $key => $val) {
            $this->integer($key);
            $this->string($val);

            $email = (new EmailTest)->setType($key);
            $this->integer($email->getType())->isEqualTo($key);
            $this->string($email->getTypeCode())->isEqualTo($val);
        }
    }

    public function testCallback()
    {
        $types    = EmailTest::getTypes();
        $callback = EmailTest::getEmailTypeCallbackValidation();

        $this->sizeOf($callback)->isEqualTo(count($types));
        $this->array($callback)->containsValues($types);
    }

    public function testFra()
    {
        $email = new EmailTest;
        $fra   = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = 140);
        $this->object($email->setFra($fra))->isIdenticalTo($email);
        $this->object($email->getFra())->isIdenticalTo($fra);
        $this->integer($email->getFra()->getId())->isEqualTo($id);
    }
}
