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

use Asbo\WhosWhoBundle\Doctrine\DefaultManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Asbo\WhosWhoBundle\Model\FraUserInterface;
use Asbo\WhosWhoBundle\Entity\Fra;
use Symfony\Component\Form\FormInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

/**
 * Fra manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraManager extends DefaultManager
{
    /**
     * Form Filter
     *
     * @var \Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface
     */
    protected $filterQueryBuilder;

    /**
     * Constructor.
     *
     * @param ObjectManager $om
     * @param ObjectRepository $repository
     * @param FilterBuilderUpdaterInterface $filterQueryBuilder
     */
    public function __construct(ObjectManager $om, ObjectRepository $repository, FilterBuilderUpdaterInterface $filterQueryBuilder)
    {
        parent::__construct($om, $repository);
        $this->filterQueryBuilder = $filterQueryBuilder;
    }

    /**
     * Find a fra by user
     *
     * @param  FraUserInterface $user
     * @return Fra[]|null
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
}
