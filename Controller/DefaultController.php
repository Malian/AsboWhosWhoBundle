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
use Asbo\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Base Controller
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class DefaultController extends ResourceController
{
    /**
     * Create an resource
     */
    public function createAction(Fra $fra, Request $request)
    {
        $this->isAllowedToEditFraOrException($fra);

        $object = $this->getManager()->createNew();
        $form = $this->getForm()->setData($object)->handleRequest($request);

        if ($form->isValid()) {

            $object->setFra($fra);
            $this->getManager()->update($object);
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
     * Update an entity.
     */
    public function updateAction(Fra $fra, Request $request)
    {
        $object = $this->findByFraOr404($fra);

        $this->isAllowedToEditFraOrException($object->getFra());

        $form = $this->getForm()->setData($object)->handleRequest($request);

        if ($form->isValid()) {

            $this->getManager()->update($object);

            $this->setFlash(
                'success',
                'Votre adresse a bien été modifiée !'
            );

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('update.html',
            [
                'fra'  => $fra,
                $this->getConfiguration()->getResourceName() => $object,
                'form' => $form->createView()
            ]
        );

    }

    /**
     * Delete an entity.
     */
    public function deleteAction(Fra $fra, Request $request)
    {
        $object = $this->findByFraOr404($fra);

        $this->isAllowedToEditFraOrException($fra);

        $form = $this->getDeleteForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($form->get('delete')->isClicked()) {
                $this->getManager()->delete($object);
                $this->setFlash('success', 'Votre adresse a bien été supprimée !');
            }

            return $this->redirect($this->getFraController()->getFraEditUrl($fra));
        }

        return $this->renderResponse('delete.html',
            [
                $this->getConfiguration()->getResourceName() => $object,
                'form' => $form->createView()
            ]
        );

    }

    /**
     * Returns an object linked to a fra or create a not found exception
     *
     * @param  Fra                                                           $fra
     * @param  array|null                                                    $criteria
     * @return object
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function findByFraOr404(Fra $fra, array $criteria = null)
    {
        if (empty($criteria)) {
            $id = $this->getRequest()->get(sprintf('%s_id', $this->getConfiguration()->getResourceName()));
            $criteria = array('id' => $id);
        }

        $criteria = array_merge($criteria, array('fra' => $fra));

        $object = $this->getManager()->getRepository()->findOneBy($criteria);

        if (null === $object) {
            throw $this->createNotFoundException(
                sprintf('There is no object linked to fra "%s"', $fra->getSlug())
            );
        }

        return $object;
    }

    /**
     * Returns a secured form.
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function getDeleteForm()
    {
        $form = $this->createFormBuilder()
            ->add('delete', 'submit')
            ->add('cancel', 'submit')
        ;

        return $form->getForm();
    }

    /**
     * Returns the form factory.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getForm()
    {
        return $this->get($this->getConfiguration()->getServiceName('form.factory'))->createForm();
    }

    /**
     * Returns the object manager.
     *
     * @return \Asbo\WhosWhoBundle\Doctrine\DefaultManager
     */
    protected function getManager()
    {
        return $this->get($this->getConfiguration()->getServiceName('manager'));
    }

    /**
     * Returns the controller that manipulates fra.
     *
     * @return \Asbo\WhosWhoBundle\Controller\FraController
     */
    protected function getFraController()
    {
        return $this->get('asbo_whoswho.controller.fra');
    }

    /**
     * Returns an exception if user are not allowed to edit the fra
     *
     * @param  Fra                                                              $fra
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function isAllowedToEditFraOrException(Fra $fra)
    {
        if (!$this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            throw new AccessDeniedException(
                'You are not allowed to edit this fra !'
            );
        }
    }
}
