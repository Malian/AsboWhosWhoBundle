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
use Asbo\WhosWhoBundle\Entity\Address;

/**
 * Address admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AddressAdmin extends Admin
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
        $address = $formMapper->create(
            'address',
            'gmap_address',
            array('show_all' => true, 'data_class' => 'Asbo\WhosWhoBundle\Entity\Address')
        );

        $formMapper
           ->add('type', 'choice', array('choices' => Address::getTypes(), 'expanded' => false, 'multiple' => false))
           ->add($address);

        if (!$this->isChild()) {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fra')
            ->add('address')
            ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Address::getTypes())));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('address')
            ->add('TypeCode');

        if (!$this->isChild()) {
            $listMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AsboWhosWhoBundle:Admin:address_edit.html.twig';
                break;
            case 'create':
                return 'AsboWhosWhoBundle:Admin:address_create.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
