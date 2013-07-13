<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Email;

/**
 * Email admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class EmailAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected $parentAssociationMapping = 'fra';

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('email')
                   ->add('type', 'choice', array('choices' => Email::getTypes(), 'expanded' => true, 'multiple' => false));

        if (!$this->isChild()) {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fra')
                       ->add('email')
                       ->add('type', null, array('field_type' => 'choice', 'field_options' => array('choices' => Email::getTypes())));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('email')
                   ->add('getTypeCode', 'text', array('label' => 'Type', 'sortable' => 'Type'));

        if (!$this->isChild()) {
            $listMapper->add('fra', 'sonata_type_model_list');
        }

    }
}
