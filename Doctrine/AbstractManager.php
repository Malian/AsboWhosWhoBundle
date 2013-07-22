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
 * Address manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AbstractManager
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
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $om
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
     * Returns the fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Updates an entity.
     *
     * @param object  $entity
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
     * Returns the repositry.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRespository()
    {
        return $this->repository;
    }
}
