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
 
/**
 * Voter 
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class OwnerVoter implements VoterInterface
{
    /**
     * @inheritdoc
     */
    public function supportsAttribute($attribute)
    {
        return 1 === preg_match('/^ROLE_WHOSWHO_FRA/', $attribute);
    }
 
    /**
     * @inheritdoc
     */
    public function supportsClass($class)
    {
        return $class instanceof Asbo\WhosWhoBundle\Entity\Fra;
    }
 
    /**
     * @inheritdoc
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $vote = VoterInterface::ACCESS_ABSTAIN;
 
        foreach ($attributes as $attribute) {

            if (false === $this->supportsAttribute($attribute) or
                false === $this->supportsClass($object)) {
                continue;
            }
 
            $user = $token->getUser();
            $vote = VoterInterface::ACCESS_DENIED;
 
            foreach ($object->getFraHasUsers() as $link) {
                if ($link->getUser()->isUser($user)) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return $vote;
    }
}
