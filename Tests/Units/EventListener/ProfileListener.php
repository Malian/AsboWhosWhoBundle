<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\EventListener;

use Asbo\WhosWhoBundle\EventListener\ProfileListener as ProfileListenerTested;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Asbo\WhosWhoBundle\Tests\Units;

class ProfileListener extends Units\Test
{
    public function testWhenNotMasterRequest()
    {
        $router            = $this->getRouterMock();
        $securityContext   = $this->getSecurityContextMock();
        $fraHasUserManager = $this->getFraHasUserManagerMock();
        $request           = $this->getRequestMock(uniqid());
        $event             = $this->getEventMock($request, uniqid());
        $listener          = new ProfileListenerTested($router, $securityContext, $fraHasUserManager, uniqid(), uniqid());

        $listener->onCoreController($event);

        $this->mock($event)
                ->call('getRequestType')
                    ->once();

        $this->mock($event)
                ->call('getRequest')
                    ->never();
    }

    public function testWhenMasterRequestAndAllValid()
    {
        $request           = $this->getRequestMock($route = uniqid(), HttpKernelInterface::MASTER_REQUEST);
        $event             = $this->getEventMock($request);
        $user              = $this->getUserMock();
        $token             = $this->getTokenMock($user);
        $securityContext   = $this->getSecurityContextMock(true, $token);
        $fra               = $this->getFraMock($slug = 'malian');
        $fraHasUser        = $this->getFraHasUserMock($fra);
        $fraHasUserManager = $this->getFraHasUserManagerMock($fraHasUser);
        $router            = $this->getRouterMock($url = uniqid());
        $listener          = new ProfileListenerTested($router, $securityContext, $fraHasUserManager, $route);

        $listener->onCoreController($event);

        $this->mock($event)

                ->call('getRequestType')
                    ->once()
                ->call('getRequest')
                    ->once()
                ->call('setResponse')
                    ->withArguments(new RedirectResponse($url))
                    ->once();

        $this->mock($request)
                ->call('get')
                    ->withIdenticalArguments('_route')
                    ->once();

        $this->mock($securityContext)
                ->call('isGranted')
                    ->withIdenticalArguments('ROLE_WHOSWHO_USER')
                    ->once()
                ->call('getToken')
                    ->once();

        $this->mock($fraHasUserManager)
                ->call('findByUserAndOwner')
                    ->once();

        $this->mock($router)
                ->call('fra')
                    ->withIdenticalArguments($fra)
                    ->once();

    }

    public function testWhenMasterRequestWithInvalidRoute()
    {
        $request           = $this->getRequestMock($route = uniqid(), HttpKernelInterface::MASTER_REQUEST);
        $event             = $this->getEventMock($request);
        $securityContext   = $this->getSecurityContextMock();
        $fraHasUserManager = $this->getFraHasUserManagerMock();
        $router            = $this->getRouterMock();
        $listener          = new ProfileListenerTested($router, $securityContext, $fraHasUserManager, uniqid());

        $listener->onCoreController($event);

        $this->mock($event)
                ->call('getRequestType')
                    ->once()
                ->call('getRequest')
                    ->once()
                ->call('setResponse')
                    ->never();

        $this->mock($request)
                ->call('get')
                    ->withIdenticalArguments('_route')
                    ->once();

        $this->mock($securityContext)
                ->call('isGranted')
                    ->never()
                ->call('getToken')
                    ->never();

        $this->mock($fraHasUserManager)
                ->call('findByUserAndOwner')
                    ->never();

        $this->mock($router)
                ->call('generate')
                    ->never();

    }

    public function testWhenMasterRequestWithValidRouteAndNotGranted()
    {
        $request           = $this->getRequestMock($route = uniqid(), HttpKernelInterface::MASTER_REQUEST);
        $event             = $this->getEventMock($request);
        $securityContext   = $this->getSecurityContextMock(false);
        $fraHasUserManager = $this->getFraHasUserManagerMock();
        $router            = $this->getRouterMock();
        $listener          = new ProfileListenerTested($router, $securityContext, $fraHasUserManager, $route);

        $listener->onCoreController($event);

        $this->mock($event)
                ->call('getRequestType')
                    ->once()
                ->call('getRequest')
                    ->once()
                ->call('setResponse')
                    ->never();

        $this->mock($request)
                ->call('get')
                    ->withIdenticalArguments('_route')
                    ->once();

        $this->mock($securityContext)
                ->call('isGranted')
                    ->withIdenticalArguments('ROLE_WHOSWHO_USER')
                    ->once()
                ->call('getToken')
                    ->never();

        $this->mock($fraHasUserManager)
                ->call('findByUserAndOwner')
                    ->never();

        $this->mock($router)
                ->call('generate')
                    ->never();

    }
    public function testWhenMasterRequestWithValidRouteAndGrantedAndNotUser()
    {
        $request           = $this->getRequestMock($route = uniqid(), HttpKernelInterface::MASTER_REQUEST);
        $event             = $this->getEventMock($request);
        $user              = $this->getUserMock();
        $token             = $this->getTokenMock($user);
        $securityContext   = $this->getSecurityContextMock(true, $token);
        $fraHasUserManager = $this->getFraHasUserManagerMock();
        $router            = $this->getRouterMock();
        $listener          = new ProfileListenerTested($router, $securityContext, $fraHasUserManager, $route);

        $listener->onCoreController($event);

        $this->mock($event)
                ->call('getRequestType')
                    ->once()
                ->call('getRequest')
                    ->once()
                ->call('setResponse')
                    ->never();

        $this->mock($request)
                ->call('get')
                    ->withIdenticalArguments('_route')
                    ->once();

        $this->mock($token)
                ->call('getUser')
                    ->once();

        $this->mock($securityContext)
                ->call('isGranted')
                    ->withIdenticalArguments('ROLE_WHOSWHO_USER')
                    ->once()
                ->call('getToken')
                    ->once();

        $this->mock($fraHasUserManager)
                ->call('findByUserAndOwner')
                    ->withIdenticalArguments($user)
                    ->once();

        $this->mock($router)
                ->call('generate')
                    ->never();

    }

    protected function getUserMock()
    {
        $mock = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface();

        return $mock;
    }

    protected function getFraHasUserManagerMock($fraHasUser = null)
    {
        $this->mockGenerator->orphanize('__construct');
        $mock = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasUserManager();
        $this->calling($mock)->findByUserAndOwner = $fraHasUser;

        return $mock;
    }

    protected function getFraHasUserMock($fra = null)
    {
        $mock = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasUser();
        $this->calling($mock)->getFra = $fra;

        return $mock;
    }

    protected function getFraMock($slug = null)
    {
        $mock = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($mock)->getSlug = $slug;

        return $mock;
    }

    protected function getEventMock($request = null, $type = HttpKernelInterface::MASTER_REQUEST)
    {
        $this->mockGenerator->orphanize('__construct');
        $mock = new \Mock\Symfony\Component\HttpKernel\Event\GetResponseEvent();
        $this->calling($mock)->getRequest = $request;
        $this->calling($mock)->getRequestType = $type;

        return $mock;
    }

    protected function getRequestMock($route = null)
    {
        $mock = new \Mock\Symfony\Component\HttpFoundation\RequestInterface();
        $this->calling($mock)->get = $route;

        return $mock;
    }

    protected function getSecurityContextMock($granted = true, $token = null)
    {
        $mock = new \Mock\Symfony\Component\Security\Core\SecurityContextInterface();
        $this->calling($mock)->isGranted = $granted;
        $this->calling($mock)->getToken  = $token;

        return $mock;
    }

    protected function getTokenMock($user = null)
    {
        $mock = new \Mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface();
        $this->calling($mock)->getUser = $user;

        return $mock;
    }

    protected function getRouterMock($url = null)
    {
        $this->mockGenerator->orphanize('__construct');
        $mock = new \Mock\Asbo\WhosWhoBundle\Routing\UrlGenerator();
        $this->calling($mock)->generate = $url;

        return $mock;
    }
}
