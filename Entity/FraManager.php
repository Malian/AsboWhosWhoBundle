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
use Asbo\WhosWhoBundle\Model\FraUserInterface;
use Symfony\Component\Form\FormInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

/**
 * Fra manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraManager
{
    /**
     * Entity Manager
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Form Filter
     *
     * @var Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface
     */
    protected $filterQueryBuilder;

    /**
     *  Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, FilterBuilderUpdaterInterface $filterQueryBuilder)
    {
        $this->em                     = $em;
        $this->filterQueryBuilder = $filterQueryBuilder;
    }

    /**
     * Persist and flush automaticly the entity
     *
     * @param Asbo\WhosWhoBundle\Entity\Fra $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Find a fra by user
     *
     * @param  Asbo\WhosWhoBundle\Model\UserFraInterface $user
     * @return Fra|DoctrineCollection|null
     */
    public function findByUser(FraUserInterface $user)
    {
        return $this->getRepository()->findBy(array('user' => $user));
    }

    /**
     * Find fras with form filter
     *
     */
    public function findAllWithFormFilter(FormInterface $form)
    {
        $filterBuilder = $this->getRepository()->createQueryBuilder('e');

        $this->filterQueryBuilder->addFilterConditions($form, $filterBuilder);

        return $filterBuilder->getQuery()->getResult();
    }

    /**
     * Find all fra
     *
     * @return Fra|null
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Return the repository associate to the manager
     *
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:Fra');
    }

    /**
     * Creates a fra entity.
     *
     * @return Fra
     */
    public function create()
    {
        $class = $this->getClass();
        $fra   = new $class;

        return $fra;
    }

    /**
     * Save a fra into db
     *
     * @return Fra
     */
    public function save(Fra $fra)
    {
        $this->persistAndFlush($fra);
    }

    /**
     * Save mutliple fra
     *
     * @param array $fras
     */
    public function saveMultiple(array $fras)
    {
        foreach ($fras as $fra) {
            $this->em->persist($fra);
        }

        $this->em->flush();
    }

    /**
     * Returns the fra's fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return 'Asbo\WhosWhoBundle\Entity\Fra';
    }
}
