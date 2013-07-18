<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\FraHasUser;

/**
 * Voter
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class OwnerVoter implements VoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return 1 === preg_match('/^ROLE_WHOSWHO_FRA/', $attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class instanceof Fra;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $vote = self::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {

            if (!$this->supportsAttribute($attribute) or !$this->supportsClass($object)) {
                continue;
            }

            $vote = self::ACCESS_DENIED;

            foreach ($object->getFraHasUsers() as $link) {
                if ($this->isOwner($link, $token->getUser())) {
                    $vote = self::ACCESS_GRANTED;
                    break;
                }
            }
        }

        return $vote;
    }

    /**
     * Verifies that the user is the owner
     *
     * @param  Fra     $fra
     * @param  mixed   $user
     * @return boolean
     */
    protected function isOwner(FraHasUser $fra, $user)
    {
        if ($fra->getUser() instanceof EquatableInterface && $user instanceof UserInterface) {
            return $fra->getUser()->isEqualTo($user);
        }

        return $fra->getUser() === $user;
    }
}
