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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Controller of Addressing
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AddressingController extends ResourceController
{
    /**
     * Create an address
     */
    public function createAction(Fra $fra, Request $request)
    {
        if (!$this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            throw new AccessDeniedException(
                'You are not allowed to edit this fra !'
            );
        }

        $address = $this->getAddressManager()->createNew();
        $form = $this->getAddressForm();

        $form->setData($address)->handleRequest($request);

        if ($form->isValid()) {

            $address->setFra($fra);
            $this->getAddressManager()->update($address);
            $this->setFlash('succes', 'Votre adresse a bien été créée !');

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('create.html',
            [
                'fra'  => $fra,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Update an address.
     *
     * @ParamConverter("address", class="Asbo\WhosWhoBundle\Entity\Address", options={"id" = "address_id"})
     * @PreAuthorize("#fra.getId() == #address.getFra().getId()")
     */
    public function updateAction(Fra $fra, Address $address, Request $request)
    {
        if (!$this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $address->getFra())) {
            throw new AccessDeniedException(
                'You are not allowed to edit this fra !'
            );
        }

        $form = $this->getAddressForm()->setData($address)->handleRequest($request);

        if ($form->isValid()) {

            $this->getAddressManager()->update($address);

            $this->setFlash(
                'success',
                'Votre adresse a bien été modifiée !'
            );

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('update.html',
            [
                'fra'  => $fra,
                'address' => $address,
                'form' => $form->createView()
            ]
        );

    }

    /**
     * Delete an address.
     *
     * @ParamConverter("address", class="Asbo\WhosWhoBundle\Entity\Address", options={"id" = "address_id"})
     * @PreAuthorize("#fra.getId() == #address.getFra().getId()")
     */
    public function deleteAction(Fra $fra, Address $address, Request $request)
    {
        if (!$this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            throw new AccessDeniedException(
                'You are not allowed to edit this fra !'
            );
        }

        $form = $this->getDeleteForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->getAddressManager()->delete($address);
            $this->setFlash('success', 'Votre adresse a bien été supprimée !');

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('delete.html',
            [
                'address' => $address,
                'form' => $form->createView()
            ]
        );

    }

    /**
     * Returns a secured form.
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function getDeleteForm()
    {
        return $this->createFormBuilder()->getForm();
    }

    /**
     * Alias to add easier a flash message.
     *
     * @param  string $type
     * @param  string $message
     * @return mixed
     */
    protected function setFlash($type, $message)
    {
        return $this
            ->get('session')
            ->getFlashBag()
            ->add($type, $message)
            ;
    }

    /**
     * Returns the form factory.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getAddressForm()
    {
        return $this->get('asbo_whoswho.addressing.form.factory')->createForm();
    }

    /**
     * Returns the address manager to manipulate addresses.
     *
     * @return \Asbo\WhosWhoBundle\Doctrine\AddressManager
     */
    protected function getAddressManager()
    {
        return $this->get('asbo_whoswho.address_manager');
    }

    /**
     * Returns the controller that manipulates fra.
     *
     * @return \Asbo\WhosWhoBundle\Controller\FraController
     */
    protected function getFraController()
    {
        return $this->get('asbo.controller.frontend.fra');
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
}
