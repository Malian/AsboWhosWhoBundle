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
use Asbo\WhosWhoBundle\Form\Filter\FraFilterType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Controller of fra page
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraController extends DefaultController
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

        /** @var \Asbo\WhosWhoBundle\Doctrine\FraManager $manager */
        $manager = $this->getManager();

        if (null !== $request->get('submit-filter')) {

            $form->handleRequest($request);

            $fras = $manager->findAllWithFormFilter($form);

        } else {
            $fras = $manager->findAll();
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
    public function updateAction(Fra $fra, Request $request)
    {
        if (false === $this->isGranted('ROLE_WHOSWHO_FRA_EDIT', $fra)) {
            throw new AccessDeniedException();
        }

        $form = $this->getForm()->setData($fra)->handleRequest($request);

        if ($form->isValid()) {

            $this->getManager()->update($fra);

            return $this->redirect($this->getFraEditUrl($fra));
        }

        return $this->renderResponse('edit.html', ['fra'  => $fra, 'form' => $form->createView()]);
    }

    /**
     * Return the url to the edit page of a fra.
     *
     * @param Fra $fra
     *
     * @return string The url
     */
    public function getFraEditUrl(Fra $fra)
    {
        return $this->get('router')->generate($this->getConfiguration()->getRouteName('update'), array('slug' => $fra->getSlug()));
    }

}
