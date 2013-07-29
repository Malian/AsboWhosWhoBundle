<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Asbo\WhosWhoBundle\Security\OwnerVoter as OwnerVoterTested;
use Asbo\WhosWhoBundle\Tests\Units;

class OwnerVoter extends Units\Test
{
    const BASE_ATTRIBUTE = 'ROLE_WHOSWHO_FRA_';

    public function testInterface()
    {
        $this->object(new OwnerVoterTested())
            ->isInstanceOf('\Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    public function testAttribute()
    {
        $voter = new OwnerVotertested();

        $this->if($attribute = self::BASE_ATTRIBUTE.uniqid())
            ->then
            ->boolean($voter->supportsAttribute($attribute))
            ->isTrue()
            ->if($attribute = uniqid())
            ->then
            ->boolean($voter->supportsAttribute($attribute))
            ->isFalse();
    }

    public function testSupportsClass()
    {
        $voter = new OwnerVoterTested();

        $this->if($class = new \StdClass())
            ->then
            ->boolean($voter->supportsClass($class))
            ->isFalse()
            ->if($class = new \Asbo\WhosWhoBundle\Entity\Fra)
            ->then
            ->boolean($voter->supportsClass($class))
            ->isTrue();

    }

    public function testVoteForUnknownAttribute()
    {
        $voter      = new OwnerVoterTested();
        $token      = $this->getTokenMock();
        $object     = $this->getFraMock();
        $attributes = array(uniqid());

        $this->integer($voter->vote($token, $object, $attributes))->isEqualTo(VoterInterface::ACCESS_ABSTAIN);
    }

    public function testVoteForUnsupportClass()
    {
        $voter      = new OwnerVoterTested();
        $token      = $this->getTokenMock();
        $object     = new \StdClass();
        $attributes = array(self::BASE_ATTRIBUTE.uniqid());

        $this->integer($voter->vote($token, $object, $attributes))->isEqualTo(VoterInterface::ACCESS_ABSTAIN);
    }

    public function testVoteForEmptyOwners()
    {
        $voter      = new OwnerVoterTested();
        $token      = $this->getTokenMock();
        $object     = $this->getFraMock();
        $attributes = array(self::BASE_ATTRIBUTE.uniqid());

        $this->integer($voter->vote($token, $object, $attributes))->isEqualTo(VoterInterface::ACCESS_DENIED);
    }

    public function testVoteForNonEqualOwner()
    {
        $voter         = new OwnerVoterTested();
        $user          = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface();
        $fraHasUser    = new \Asbo\WhosWhoBundle\Entity\FraHasUser();
        $fraHasUsers   = new \Doctrine\Common\Collections\ArrayCollection();
        $fraHasUsers[] = $fraHasUser;
        $token         = $this->getTokenMock();
        $object        = $this->getFraMock();
        $attributes    = array(self::BASE_ATTRIBUTE.uniqid());

        $fraHasUser->setUser($user);
        $this->calling($token)->getUser = new \StdClass();
        $this->calling($object)->getFraHasUsers = $fraHasUsers;
        $this->integer($voter->vote($token, $object, $attributes))->isEqualTo(VoterInterface::ACCESS_DENIED);
    }

    public function testVoteForEqualOwner()
    {
        $voter         = new OwnerVoterTested();
        $user          = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface();
        $fraHasUser    = new \Asbo\WhosWhoBundle\Entity\FraHasUser();
        $fraHasUsers   = new \Doctrine\Common\Collections\ArrayCollection();
        $fraHasUsers[] = $fraHasUser;
        $token         = $this->getTokenMock();
        $object        = $this->getFraMock();
        $attributes    = array(self::BASE_ATTRIBUTE.uniqid());

        $fraHasUser->setUser($user);
        $this->calling($user)->isEqualTo = true;
        $this->calling($token)->getUser = $user;
        $this->calling($object)->getFraHasUsers = $fraHasUsers;
        $this->integer($voter->vote($token, $object, $attributes))->isEqualTo(VoterInterface::ACCESS_GRANTED);
    }

    protected function getTokenMock()
    {
        return new \Mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface();
    }

    protected function getFraMock()
    {
        return new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
    }

    protected function getFraHasUsersMock()
    {
        return new \Doctrine\Common\Collections\ArrayCollection();
    }

    protected function getFraHasUserMock()
    {
        return new \Asbo\WhosWhoBundle\Entity\FraHasUser();
    }
}
