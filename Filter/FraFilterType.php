<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Asbo\WhosWhoBundle\Entity\Fra;

class FraFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
                ->add('lastname', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
                ->add('nickname', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
                ->add('anno', 'filter_number', array('condition_operator' => FilterOperands::OPERAND_SELECTOR))
                ->add('gender', 'filter_choice', array('choices' => array(0 => 'Mâle', 1 => 'Sexe faible')))
                ->add('type', 'filter_choice', array('choices' => Fra::GetTypesList()))
                ->add('status', 'filter_choice', array('choices' => Fra::GetStatusList()));

        $builder->add('fraHasPosts', new FraHasPostsFilterType(), array('label' => false));
    }

    public function getName()
    {
        return 'fra_filter_type';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            )
        );
    }
}
