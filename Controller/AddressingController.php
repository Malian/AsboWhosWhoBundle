<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Controller;

use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\Address;
use Asbo\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Controller of comite page
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AddressingController extends ResourceController
{
    /**
     * Edit an address
     *
     * @throws AccessDeniedException if the user are not allowed
     * @ParamConverter("address", class="Asbo\WhosWhoBundle\Entity\Address", options={"id" = "address_id"})
     */
    public function editAction(Fra $fra, Address $address, Request $request)
    {
        if ($address->getFra()->getId() !== $fra->getId()) {
            throw $this->createNotFoundException('Link between Fra and Address not found !');
        }

        if (!$this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $address->getFra())) {
            throw new AccessDeniedException('You are not allowed to edit this fra !');
        }

        $form = $this->getFormFactory()->setData($address)->handleRequest($request);

        if ($form->isValid()) {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre addresse a bien été modifiée !'
            );

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('edit.html', ['fra'  => $fra, 'address' => $address, 'form' => $form->createView()]);

    }

    /**
     * Returns the form factory.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getFormFactory()
    {
        return $this->container->get('asbo_whoswho.addressing.form.factory')->createForm();
    }

    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied object.
     *
     * @param mixed      $attributes
     * @param mixed|null $object
     *
     * @return boolean
     */
    protected function isGranted($attributes, $object = null)
    {
        return $this->get('security.context')->isGranted($attributes, $object);
    }

    /**
     * @return \Asbo\WhosWhoBundle\Controller\FraController
     */
    protected function getFraController()
    {
        return $this->get('asbo.controller.frontend.fra');
    }
}
