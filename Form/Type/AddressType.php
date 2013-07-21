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

/**
 * Address type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AddressType extends AbstractType
{
    private $class;

    /**
     * @param string $class The Address class name
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
        /** @var \Asbo\WhosWhoBundle\Entity\Address $class */
        $class = $this->class;

        $builder->add('address', null, array('required' => true))
                ->add('type', 'choice', array('choices' => $class::getTypes()))
                ->add('locality', null, array('required' => false))
                ->add('country', null, array('required' => false))
                ->add('lat', 'text', array('required' => false, 'read_only' => true))
                ->add('lng', 'text', array('required' => false, 'read_only' => true));
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->class
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_address';
    }
}
