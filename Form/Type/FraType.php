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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;
use Doctrine\ORM\EntityRepository;

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
    private $class;

    /**
     * @param string $class The Fra class name
     */
    public function __construct($class)
    {
        $this->class = $class;
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

                ->addEventListener(
                    FormEvents::PRE_SET_DATA,
                    function (FormEvent $event) {
                        $data = $event->getData();
                        $form = $event->getForm();

                        // Lorsque le formulaire est créé, l'entité passée est vide
                        if (null === $data || null === $data->getId()) {
                            return;
                        }

                        $closure = function (EntityRepository $er) use ($data) {
                            return $er->createQueryBuilder('a')
                                      ->where('a.fra = :fra')
                                      ->setParameter('fra', $data);
                        };

                        $form->add('principalAddress', null, array('query_builder' => $closure));
                        $form->add('principalPhone', null, array('query_builder' => $closure));
                        $form->add('principalEmail', null, array('query_builder' => $closure));
                    }
                )
                ->addEventListener(
                    FormEvents::POST_SET_DATA,
                    function (FormEvent $event) {
                        $data = $event->getData();
                        $form = $event->getForm();

                        // Lorsque le formulaire est créé, l'entité passée est vide
                        if (null === $data || null === $data->getId()) {
                            return;
                        }

                        if (0 === count($data->getAddresses())) {
                            $form->remove('principalAddress');
                        }
                    }
                )
                ->add('fraHasPosts', 'collection', array('by_reference' => false, 'type' => 'asbo_type_fraHasPost',
                    'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('addresses', 'collection', array('by_reference' => false, 'type' => 'asbo_type_address', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('emails', 'collection', array('by_reference' => false, 'type' => 'asbo_type_email', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('phones', 'collection', array('by_reference' => false, 'type' => 'asbo_type_phone', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true))
                ->add('diplomas', 'collection', array('by_reference' => false, 'type' => 'asbo_type_diploma', 'allow_add' => true, 'allow_delete' => true, 'prototype' => true));
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
