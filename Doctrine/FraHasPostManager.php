<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Doctrine;

use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\FraHasPost;

/**
 * Fra has Post manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraHasPostManager extends EntityManager
{

    /**
     * Find a fraHasPost by fra
     *
     * @param \Asbo\WhosWhoBundle\Entity\Fra $fra
     *
     * @return FraHasPost[]
     */
    public function findByFra(Fra $fra)
    {
        return $this->getRepository()->findBy(array('fra' => $fra));
    }

    /**
     * Find all posts
     *
     * @param  array|null
     * @return FraHasPost[]
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Find all posts by type
     *
     * @param  array|null
     *
     * @throws \Exception
     * @return FraHasPost[]|null
     */
    public function findByTypes($types)
    {
        if (!is_array($types) && is_string($types)) {
            $types = array($types);
        }

        if (!is_array($types)) {
            throw new \Exception('Type pas bon !');
        }

        return $this->getRepository()->findByTypes($types);
    }

    /**
     * Find all posts by type and year
     *
     * @param  array|null
     * @param  integer           $year
     * @throws \Exception
     * @return FraHasPost[]|null
     */
    public function findByTypesAndYear($types, $year)
    {
        if (!is_array($types) && is_string($types)) {
            $types = array($types);
        }

        if (!is_array($types)) {
            throw new \Exception('Type pas bon !');
        }

        return $this->getRepository()->findByTypesAndYear($types, $year);
    }

    /**
     * Returns the repositry.
     *
     * @return \Asbo\WhosWhoBundle\Doctrine\FraHasPostRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
