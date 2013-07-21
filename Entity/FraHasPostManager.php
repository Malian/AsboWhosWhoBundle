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

/**
 * Fra has Post manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraHasPostManager
{
    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Persist and flush automaticly the entity
     *
     * @param \Asbo\WhosWhoBundle\Entity\FraHasPost $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Find a fra by fra
     *
     * @param \Asbo\WhosWhoBundle\Entity\Fra $fra
     *
     * @return FraHasPost|\Doctrine\Common\Collections\ArrayCollection|null
     */
    public function findByFra(Fra $fra)
    {
        return $this->getRepository()->findBy(array('fra' => $fra));
    }

    /**
     * Find all posts
     *
     * @param  array|null
     * @return FraHasPost|null
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
     * Return the repository associate to the manager
     *
     * @return \Asbo\WhosWhoBundle\Entity\FraHasPostRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:FraHasPost');
    }

    /**
     * Creates a fra entity.
     *
     * @return Fra
     */
    public function create()
    {
        $class      = $this->getClass();
        $fraHasPost = new $class;

        return $fraHasPost;
    }

    /**
     * Save a fra into db
     *
     * @param FraHasPost $fra
     *
     * @return \Asbo\WhosWhoBundle\Entity\Fra
     */
    public function save(FraHasPost $fra)
    {
        $this->persistAndFlush($fra);
    }

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    protected function getClass()
    {
        return 'Asbo\WhosWhoBundle\Entity\FraHasPost';
    }
}
