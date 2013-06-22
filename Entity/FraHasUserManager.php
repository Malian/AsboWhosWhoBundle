<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\EntityManager;
use Asbo\WhosWhoBundle\Model\FraUserInterface as User;

/**
 * Fra has Post manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraHasUserManager
{
    /**
     * Entity Manager
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Find an user and if the user is owner
     *
     * @param  User       $fra
     * @return FraHasUser
     */
    public function findByUserAndOwner(User $user)
    {
        return $this->getRepository()->findOneBy(array('user' => $user, 'owner' => true));
    }

    /**
     * Return the repository associate to the manager
     *
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:FraHasUser');
    }

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return 'Asbo\WhosWhoBundle\Entity\FraHasUser';
    }
}
