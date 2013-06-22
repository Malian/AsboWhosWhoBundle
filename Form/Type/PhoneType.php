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
use Asbo\WhosWhoBundle\Entity\Phone;

/**
 * Phone type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class PhoneType extends AbstractType
{
    private $class;

    /**
     * @param string $class The Phone class name
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
        $builder->add('number')
                ->add('type', 'choice', array('choices' => Phone::getTypes()))
                ->add('country', 'country', array('preferred_choices' => array('BE', 'FR')))
                ->add('principal');
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
        return 'asbo_type_phone';
    }
}
