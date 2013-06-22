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
 * FraHasPost type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraHasPostType extends AbstractType
{
    private $class;

    /**
     * @param string $class The FraHasPost class name
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
        $builder->add('post', 'entity', array('class' => 'AsboWhosWhoBundle:Post'))
                ->add('date', 'asbo_type_annotext');
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
        return 'asbo_type_fraHasPost';
    }
}
