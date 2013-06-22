<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Asbo\WhosWhoBundle\Routing\UrlGenerator;
use Asbo\WhosWhoBundle\Entity\FraHasUserManager;

/**
 * Profile event listener
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class ProfileListener
{
    /**
     * @var Asbo\WhosWhoBundle\Routing\UrlGenerator
     */
    public $generator;

    /**
     * @var Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    public $securityContext;

    /**
     * @var Asbo\WhosWhoBundle\Entity\FraHasUserManager  $fraHasUserManager
     */
    public $fraHasUserManager;

    /**
     * @var string $route
     */
    public $route;

    /**
     * @param \Asbo\WhosWhoBundle\Routing\UrlGenerator                  $generator
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     * @param \Asbo\WhosWhoBundle\Entity\FraUserManager                 $fraHasUserManager
     * @param string                                                    $route
     */
    public function __construct(
        UrlGenerator $generator,
        SecurityContextInterface $securityContext,
        FraHasUserManager $fraHasUserManager,
        $route
    ) {
        $this->generator         = $generator;
        $this->securityContext   = $securityContext;
        $this->fraHasUserManager = $fraHasUserManager;
        $this->route             = $route;
    }

    /**
     * Event called when a user going to his profile and if he is en ROLE_WHOSWHO_USER
     *
     * @param FilterControllerEvent $event
     */
    public function onCoreController(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $routeName = $event->getRequest()->get('_route');

            if ($routeName === $this->route && $this->securityContext->isGranted('ROLE_WHOSWHO_USER')) {

                $user       = $this->securityContext->getToken()->getuser();
                $fraHasUser = $this->fraHasUserManager->findByUserAndOwner($user);

                if (count($fraHasUser) > 0) {
                    $url = $this->generator->fra($fraHasUser->getFra());
                    $event->setResponse(new RedirectResponse($url));
                }
            }
        }
    }
}
