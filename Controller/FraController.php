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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Filter\FraFilterType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\UserBundle\Model\UserInterface;
use Asbo\ResourceBundle\Controller\ResourceController;

/**
 * Controller of fra page
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraController extends ResourceController
{
    /**
     * @Secure(roles="ROLE_WHOSWHO_USER")
     * @todo Injecter le filtre dans le manager
     */
    public function listAction()
    {

        $form = $this->get('form.factory')->create(new FraFilterType());

        if ($this->get('request')->query->has('submit-filter')) {
            // bind values from the request
            $form->bind($this->get('request'));

            // initliaze a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AsboWhosWhoBundle:Fra')
                ->createQueryBuilder('e');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            // now look at the DQL =)
            $fras = $filterBuilder->getQuery()->getResult();

        } else {
            $fraManager = $this->container->get('asbo_whoswho.fra_manager');
            $fras       = $fraManager->findAll();
        }

        return $this->renderResponse(
            'list.html',
            array(
                'fras' => $fras,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Secure(roles="ROLE_WHOSWHO_USER")
     * @ParamConverter("fra", class="AsboWhosWhoBundle:Fra")
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
     * @Secure(roles="ROLE_WHOSWHO_USER")
     */
    public function editAction(Fra $fra, Request $request)
    {
        if (!$this->canEdit($fra) && !$this->container->get('security.context')->isGranted('ROLE_WHOSWHO_CHANCELIER')) {
            throw new AccessDeniedException('This user does not have access to this section');
        }

         /** @var $formFactory \Asbo\WhosWhoBundle\Form\Factory\FormFactory */
        $form = $this->container->get('asbo_whoswho.fra.form.factory')->createForm();
        $form->setData($fra);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {

                /** @var $fraManager \Asbo\WhosWhoBundle\Entity\FraManager */
                $userManager = $this->container->get('asbo_whoswho.fra_manager');
                $userManager->save($fra);

                $url = $this->container->get('router')->generate('asbo_whoswho_fra_edit', array('slug' => $fra->getSlug()));
                $response = new RedirectResponse($url);

                return $response;
            }
        }

        return $this->renderResponse(
            'edit.html',
            array(
                'fra'  => $fra,
                'form' => $form->createView()
            )
        );
    }

    protected function canEdit($fra)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        foreach ($fra->getFraHasUsers() as $link) {
            if ($link->getUser()->isUser($user)) {
                return true;
            }
        }

        return false;
    }
}
