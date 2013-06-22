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

/**
 * Settings type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class SettingsType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('keys' => array(
                array('whoswho'              , 'checkbox', array('required' => false)),
                array('pereat'               , 'checkbox', array('required' => false)),
                array('convoc_externe'       , 'checkbox', array('required' => false)),
                array('convoc_banquet'       , 'checkbox', array('required' => false)),
                array('convoc_we'            , 'checkbox', array('required' => false)),
                array('convoc_ephemerides_q1', 'checkbox', array('required' => false)),
                array('convoc_ephemerides_q2', 'checkbox', array('required' => false)),
            ))
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'sonata_type_immutable_array';
    }
}
