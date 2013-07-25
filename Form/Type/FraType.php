<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;
use Asbo\WhosWhoBundle\Form\EventListener\EditFraListener;

// @Todo: Changer ici par une interface parce que normalement on devrait pas devoir utiliser directement la classe
// puisqu'elle est contenue dans $this->class...
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Fra type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraType extends AbstractType
{
    /**
     * @var string $class
     */
    private $class;

    /**
     * @var EditFraListener $editFraListener;
     */
    private $editFraListener;

    /**
     * @param string          $class           The Fra class name
     * @param EditFraListener $editFraListener
     */
    public function __construct($class, EditFraListener $editFraListener)
    {
        $this->class = $class;
        $this->editFraListener = $editFraListener;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', null, array('disabled' => true))
                ->add('lastname', null, array('disabled' => true))
                ->add('nickname')
                ->add('gender', 'choice', array('choices' => array('Homme', 'Femme'), 'disabled' => true))
                ->add('bornAt', 'birthday')
                ->add('bornIn')
                ->add('type', 'choice', array('choices' => Fra::getTypesList(), 'disabled' => true))
                ->add('status', 'choice', array('choices' => Fra::getStatusList(), 'disabled' => true))
                ->add('anno', 'choice', array('choices' => AnnoManipulator::getAnnos() ,'disabled' => true))
                ->add('pontif', 'checkbox', array('required' => false, 'disabled' => true))
                ->add('fraHasPosts', 'collection', array('by_reference' => false, 'type' => 'asbo_type_fraHasPost', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('addresses', 'collection', array('by_reference' => false, 'type' => 'asbo_type_address', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('emails', 'collection', array('by_reference' => false, 'type' => 'asbo_type_email', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('phones', 'collection', array('by_reference' => false, 'type' => 'asbo_type_phone', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('diplomas', 'collection', array('by_reference' => false, 'type' => 'asbo_type_diploma', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true));

        $builder->addEventSubscriber($this->editFraListener);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'cascade_validation' => true,
                'data_class' => $this->class
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_fra';
    }
}
