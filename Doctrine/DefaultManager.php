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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Abstract Manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class DefaultManager
{
    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $om;

    /**
     * Entity Repository
     *
     * @var \Doctrine\Common\Persistence\ObjectRepository $repository
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
     * @param ObjectManager    $om
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectManager $om, ObjectRepository $repository)
    {
        $this->om = $om;
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
        $this->om->persist($entity);

        if ($andFlush) {
            $this->om->flush();
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
        $this->om->remove($entity);

        if ($andFlush) {
            $this->om->flush();
        }
    }

    /**
     * Returns the repositry.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
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
