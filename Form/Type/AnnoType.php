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
use Asbo\WhosWhoBundle\Util\AnnoManipulator;
use Symfony\Component\OptionsResolver\Options;

/**
 * Anno type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AnnoType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choicesCallback = function (Options $options, $value) {
            $annos = AnnoManipulator::getAnnos();

            return $options['inverse_choices'] ? array_reverse($annos, true) : $annos;
        };

        $resolver->setDefaults(
            array(
                'invalid_message' => 'L\'anno {{ value }} n\'existe pas à l\'ASBO !',
                'inverse_choices' => true,
                'choices' => $choicesCallback
            )
        );

        $resolver->setAllowedValues(
            array(
               'inverse_choices' => array(true, false, 0, 1)
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_anno';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'choice';
    }
}
