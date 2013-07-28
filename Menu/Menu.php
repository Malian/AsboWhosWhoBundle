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

/**
 * Abstract menu builder.
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class Menu extends MenuBuilder
{

    protected $request;

    /**
     * Builds fra menu.
     *
     * @param Request $request
     * @param Fra     $fra
     *
     * @return ItemInterface
     */
    public function FraMenu(Fra $fra)
    {
        $menu = $this->factory->createItem('root', array(
                'childrenAttributes' => array(
                    'class' => 'nav nav-pills'
                )
            ));

        $menu->setCurrent($this->request->getRequestUri());

        if ($this->securityContext->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            $menu->addChild('edit', array(
                    'route' => 'asbo_whoswho_fra_update',
                    'linkAttributes' => array('title' => $this->translate('asbo.frontend.menu.edit.fra')),
                    'labelAttributes' => array('icon' => 'icon-edit icon-large', 'iconOnly' => false)
                ))->setLabel($this->translate('asbo.frontend.menu.edit.fra'));
        }

        return $menu;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function factory(Request $request)
    {
        $this->request = $request;
        return $this;
    }
}