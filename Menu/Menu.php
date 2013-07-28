<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Menu;


use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Asbo\WhosWhoBundle\Entity\Fra;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Abstract menu builder.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class Menu extends ContainerAware
{
    /**
     * Builds fra menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory
     * @param array $options
     * @throws \InvalidArgumentException
     *
     * @return ItemInterface
     */
    public function fra(FactoryInterface $factory, array $options)
    {
        if (empty($options['fra'])) {
            throw new \InvalidArgumentException('Missing parameter "fra" !');
        }

        /** @var \Asbo\WhosWhoBundle\Entity\Fra $fra */
        $fra = $options['fra'];
        $route = $this->getRequest()->get('_route');

        $menu = $factory->createItem('root',
            [
                'childrenAttributes' =>
                [
                    'class' => 'nav nav-pills'
                ]
            ]
        );

        $menu->setCurrent($this->getRequest()->getRequestUri());

        if ($route !== 'asbo_whoswho_fra_show') {
            $menu->addChild('show',
                [
                    'route' => 'asbo_whoswho_fra_show',
                    'routeParameters' => ['slug' => $fra->getSlug()],
                    'labelAttributes' => ['icon' => 'icon-user icon-large', 'iconOnly' => false]
                ]
            )->setLabel('asbo_whoswho.menu.fra.show');
        }

        if ($this->isAllowedToEditFra($fra) && $route !== 'asbo_whoswho_fra_edit') {
            $menu->addChild('edit',
                [
                    'route' => 'asbo_whoswho_fra_update',
                    'routeParameters' => ['slug' => $fra->getSlug()],
                    'labelAttributes' => ['icon' => 'icon-edit icon-large', 'iconOnly' => false]
                ]
            )->setLabel('asbo_whoswho.menu.fra.edit');
        }


        $menu->addChild('addresses',
            [
                'route' => 'asbo_whoswho_address_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-home icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.address.list');

        $menu->addChild('diplomas',
            [
                'route' => 'asbo_whoswho_diploma_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-print icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.diploma.list');

        $menu->addChild('emails',
            [
                'route' => 'asbo_whoswho_email_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-envelope-alt icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.email.list');

        $menu->addChild('phones',
            [
                'route' => 'asbo_whoswho_phone_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-phone icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.phone.list');

        $menu->addChild('frahasposts',
            [
                'route' => 'asbo_whoswho_frahaspost_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-lightbulb icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.frahaspost.list');

        $menu->addChild('ranks',
            [
                'route' => 'asbo_whoswho_rank_list',
                'routeParameters' => ['slug' => $fra->getSlug()],
                'labelAttributes' => ['icon' => 'icon-thumbs-down icon-large', 'iconOnly' => false]
            ]
        )->setLabel('asbo_whoswho.menu.rank.list');

        return $menu;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * Returns an exception if user are not allowed to edit the fra
     *
     * @param  Fra  $fra
     * @return bool
     */
    protected function isAllowedToEditFra(Fra $fra)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            return false;
        }

        return true;
    }
}