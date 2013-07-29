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
use Symfony\Component\Form\FormBuilderInterface;
use Asbo\WhosWhoBundle\Form\DataTransformer\StringToAnnoTransformer;

/**
 * Anno text type
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AnnoTextType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array('choices' => array('Anno', 'Année Civil')))
                ->add('date', 'text')
                ->addViewTransformer(new StringToAnnoTransformer());
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_whoswho_anno_text';
    }
}
