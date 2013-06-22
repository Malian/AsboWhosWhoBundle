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

use Asbo\WhosWhoBundle\Entity\FraHasUser as FraHasUserTest;
use Asbo\WhosWhoBundle\Tests\Units;

class FraHasUser extends Units\Test
{
    public function testInit()
    {
        $fraHasUser = new FraHasUserTest;

        $this->variable($fraHasUser->getId())->isNull();
        $this->variable($fraHasUser->getFra())->isNull();
        $this->variable($fraHasUser->getUser())->isNull();
        $this->variable($fraHasUser->getUpdatedAt())->isNull();
        $this->variable($fraHasUser->getCreatedAt())->isNull();
        $this->boolean($fraHasUser->isOwner())->isTrue();
    }

    public function testToString()
    {
        $fraHasUser = new FraHasUserTest;

        $this->castToString($fraHasUser)
                ->isEqualTo(' | ');

        $fraHasUser->setUser($this->createUserMock($firstname = 'Malian'));
        $fraHasUser->setFra($this->createFraMock($lastname = 'De Ron'));

        $this->castToString($fraHasUser)->isEqualTo($firstname. ' | ' . $lastname);
    }

    public function testPrePersist()
    {
        $fraHasUser = new FraHasUserTest;
        $fraHasUser->prePersist();

        $this->datetime($fraHasUser->getCreatedAt())->isNotNull();
        $this->datetime($fraHasUser->getUpdatedAt())->isNotNull();
    }

    public function testPreUpdate()
    {
        $fraHasUser = new FraHasUserTest;
        $fraHasUser->preUpdate();

        $this->datetime($fraHasUser->getUpdatedAt())->isNotNull();
    }

    public function testDate()
    {
        $fraHasUser = new FraHasUserTest;
        $fraHasUser->setCreatedAt($createdAt = $this->faker->datetimeBetween('-30 years', 'now'));
        $fraHasUser->setUpdatedAt($updatedAt = $this->faker->datetimeBetween($createdAt, 'now'));

        $this->datetime($fraHasUser->getCreatedAt())->isEqualTo($createdAt);
        $this->datetime($fraHasUser->getUpdatedAt())->isEqualTo($updatedAt);

        $this->variable($fraHasUser->setUpdatedAt(null)->getUpdatedAt())->isNull();
    }

    public function testSetOwner()
    {
        $fraHasUser = new FraHasUserTest;

        $this->object($fraHasUser->setOwner(false))->isIdenticalTo($fraHasUser);
        $this->boolean($fraHasUser->isOwner())->isFalse();

        $fraHasUser->setOwner(true);
        $this->boolean($fraHasUser->isOwner())->isTrue();
    }

    public function testSetFra()
    {
        $fraHasUser = new FraHasUserTest;

        $this->object($fraHasUser->setFra($fra = $this->createFraMock()))->isIdenticalTo($fraHasUser);
        $this->object($fraHasUser->getFra())->isIdenticalTo($fra);
    }

    public function testSetUser()
    {
        $fraHasUser = new FraHasUserTest;

        $this->object($fraHasUser->setUser($post = $this->createUserMock()))->isIdenticalTo($fraHasUser);
        $this->object($fraHasUser->getUser())->isIdenticalTo($post);
    }

    protected function createFraMock($name = null)
    {
        $fraHasUser                             = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($fraHasUser)->__toString = $name;

        return $fraHasUser;
    }

    protected function createUserMock($name = null)
    {
        $user                              = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface();
        $this->calling($user)->__toString  = $name;

        return $user;
    }
}
