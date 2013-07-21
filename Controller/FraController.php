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

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Filter\FraFilterType;
use Asbo\ResourceBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Controller of fra page
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraController extends ResourceController
{
    /**
     * Show all the fra
     *
     * @Secure(roles="ROLE_WHOSWHO_USER")
     */
    public function listAction(Request $request)
    {
        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('form.factory')->create(new FraFilterType());

        if ($request->query->has('submit-filter')) {

            $form->handleRequest($request);

            $fras = $this->getFraManager()->findAllWithFormFilter($form);

        } else {
            $fras = $this->getFraManager()->findAll();
        }

        return $this->renderResponse('list.html', ['fras' => $fras, 'form' => $form->createView()]);
    }

    /**
     * Show the fra
     *
     * @Secure(roles="ROLE_WHOSWHO_USER")
     */
    public function showAction(Fra $fra)
    {
        return $this->renderResponse(
            'show.html',
            array(
                'fra' => $fra
            )
        );
    }

    /**
     * Edit the fra
     */
    public function editAction(Fra $fra, Request $request)
    {
        if (false === $this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            throw new AccessDeniedException();
        }

        $form = $this->getFormFactory()->setData($fra)->handleRequest($request);

        if ($form->isValid()) {

            $this->getFraManager()->save($fra);

            return $this->redirect($this->getFraEditUrl($fra));
        }

        return $this->renderResponse('edit.html', ['fra'  => $fra, 'form' => $form->createView()]);
    }

    /**
     * Returns the form factory.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getFormFactory()
    {
        return $this->container->get('asbo_whoswho.fra.form.factory')->createForm();
    }

    /**
     * Return the url to the edit page of a fra.
     *
     * @param Fra $fra
     *
     * @return string The url
     */
    protected function getFraEditUrl(Fra $fra)
    {
        return $this->get('router')->generate('asbo_whoswho_fra_edit', array('slug' => $fra->getSlug()));
    }

    /**
     * Return the FraManager
     *
     * @return \Asbo\WhosWhoBundle\Entity\FraManager
     */
    protected function getFraManager()
    {
        return $this->get('asbo_whoswho.fra_manager');
    }

    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied object.
     *
     * @param mixed      $attributes
     * @param mixed|null $object
     *
     * @return Boolean
     */
    protected function isGranted($attributes, $object = null)
    {
        return $this->get('security.context')->isGranted($attributes, $object);
    }
}
