<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Entity;

use Asbo\WhosWhoBundle\Entity\FraHasUserManager as FraHasUserManagerTested;
use Asbo\WhosWhoBundle\Tests\Units;

class FraHasUserManager extends Units\Test
{

    public function beforeTestMethod($method)
    {
        $this->em      = new \Mock\Doctrine\ORM\EntityManager();
        $this->fra     = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->user    = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface();
        $this->manager = new FraHasUserManagerTested($this->em);

        $this->fraHasUser = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasUser();
        $this->fraHasUser->setFra($this->fra)->setUser($this->user);

        $this->mockGenerator->orphanize('__construct');
        $this->repository = new \Mock\Doctrine\ORM\EntityRepository();
        $this->calling($this->em)->getRepository = $this->repository;
    }

    public function testConstructor()
    {
        $this->object(new FraHasUserManagerTested($this->em));
    }

    public function testFindByUserAndOwner()
    {
        $this->calling($this->repository)->findOneBy = $this->fraHasUser;
        $this->manager->findByUserAndOwner($user = $this->user);

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findOneBy')
                    ->withIdenticalArguments(array('user' => $user, 'owner' => true))
                    ->once();
    }
}
