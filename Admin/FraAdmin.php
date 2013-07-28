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
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Fra admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraAdmin extends Admin
{
    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fra = $this->getSubject();

        // Select only addresses of the fra
        $query_builder = function (EntityRepository $er) use ($fra) {
            return $er->createQueryBuilder('u')->where('u.fra = :fra')->setParameter('fra', $fra);
        };

        $formMapper
            ->with('Général')
                ->add('firstname')
                ->add('lastname')
                ->add('nickname')
                ->add('gender', 'choice', array('choices' => array('Homme', 'Femme')))
                ->add('bornAt', 'birthday', array('required' => false))
                ->add('bornIn')
                ->add('principalAddress', null, array('query_builder' => $query_builder))
                ->add('principalEmail', null, array('query_builder' => $query_builder))
                ->add('principalPhone', null, array('query_builder' => $query_builder))
            ->end()

            ->with('ASBO')
                ->add('anno', 'asbo_type_anno', array('help' =>  'Date de rentrée à l\'ASBO'))
                ->add('type', 'choice', array('choices' => Fra::getTypesList(), 'help' => 'Comment le membre est-il rentré à l\'ASBO ?'))
                ->add('status', 'choice', array('choices' => Fra::getStatusList(), 'help' =>  'Quel est son status actuel ?'))
                ->add('pontif', 'sonata_type_boolean', array('choices' => array('Non', 'Oui'), 'help' => 'Le Fra est/a-t\'il été pontif ?'))
            ->end()

            ->with('Autres', array('collapsed' => true))
                ->add('diedAt', 'birthday', array('required' => false))
                ->add('diedIn')
            ->end()

            ->with('Settings', array('collapsed' => true))
                ->add('settings', 'asbo_type_settings')
            ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname')
            ->add('lastname')
            ->add('nickname')
            ->add('anno', null, array('field_type' => 'choice', 'field_options' => array('choices' => AnnoManipulator::getAnnos())))
            ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getTypesList())))
            ->add('status', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getStatusList())));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('firstname')
            ->addIdentifier('lastname')
            ->addIdentifier('nickname')
            ->add('anno', null, array('template' => 'AsboWhosWhoBundle:Admin:list_anno.html.twig'))
            ->add('getTypeCode', 'text', array('sortable' => 'type'))
            ->add('getStatusCode')
            ->add('pontif', null, array('editable' => true));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('firstname')
            ->add('lastname')
            ->add('nickname')
            ->add('gender')
            ->add('principalAddress')
            ->add('bornAt')
            ->add('bornIn')
            ->add('diedAt')
            ->add('diedIn')
            ->add('anno')
            ->add('getAnnoToDates')
            ->add('getTypeCode')
            ->add('getStatusCode')
            ->add('pontif')
            ->add('settings', 'array');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            'Voir/Editer',
            array('uri' => $admin->generateUrl('edit', array('id' => $id)))
        );

        $menu->addChild(
            'Utilisateurs liés',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.fra_has_user.list', array('id' => $id)))
        );

        $menu->addChild(
            'Emails',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.email.list', array('id' => $id)))
        );

        $menu->addChild(
            'Téléphones',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.phone.list', array('id' => $id)))
        );

        $menu->addChild(
            'Postes ASBO',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.fra_has_post.list', array('id' => $id)))
        );

        $menu->addChild(
            'Adresses',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.address.list', array('id' => $id)))
        );

        $menu->addChild(
            'Diplomes & Etudes',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.diploma.list', array('id' => $id)))
        );

        $menu->addChild(
            'Jobs',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.job.list', array('id' => $id)))
        );

        $menu->addChild(
            'Famille',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.family.list', array('id' => $id)))
        );

        $menu->addChild(
            'Titre de guindaille',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.rank.list', array('id' => $id)))
        );

        $menu->addChild(
            'Postes Extérieurs',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.externalpost.list', array('id' => $id)))
        );

        $menu->addChild(
            'Photos',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.fra_has_image.list', array('id' => $id)))
        );

    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($entity)
    {
        // Si l'entité n'est pas déclarée comme un enfant direct
        // il faut décomenter cette ligne pour autoriser la liaison
        // @see bug in SonataMediaBundle\Admin\GalleryAdmin.php

        // $entity->setFraHasUsers($entity->getFraHasUsers());
        foreach ($entity->getFraHasUsers() as $relation) {
            $relation->preUpdate();
        }
    }
}
