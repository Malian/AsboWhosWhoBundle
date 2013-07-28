<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.cem>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager as BaseEntityManager;

/**
 * Abstract Manager
 *
 * @author De Ron Malian <deronmalian@gmail.cem>
 */
class EntityManager
{
    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * Entity Repository
     *
     * @var \Doctrine\ORM\EntityRepository $repository
     */
    protected $repository;

    /**
     * Class name
     *
     * @var string $class
     */
    protected $class;

    /**
     * Constructor
     *
     * @param BaseEntityManager $em
     * @param EntityRepository  $repository
     */
    public function __construct(BaseEntityManager $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->class = $repository->getClassName();
    }

    /**
     * Creates an new entity.
     *
     * @return object
     */
    public function createNew()
    {
        $class = $this->getClass();

        return new $class;
    }

    /**
     * Updates the specified instance of an entity.
     *
     * @param object  $entity   The entity to update
     * @param boolean $andFlush
     */
    public function update($entity, $andFlush = true)
    {
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * Deletes the specified instance of an entity
     *
     * @param mixed $entity   The entity to save
     * @param bool  $andFlush
     */
    public function delete($entity, $andFlush = true)
    {
        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * Returns the repositry.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Returns the fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
