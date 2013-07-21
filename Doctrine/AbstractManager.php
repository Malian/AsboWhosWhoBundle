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
     * @var \Doctrine\Common\Persistence\ObjectRepository $repository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->om = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
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
}
