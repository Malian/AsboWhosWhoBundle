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

use Asbo\WhosWhoBundle\Entity\FraManager as FraManagerTested;
use Asbo\WhosWhoBundle\Tests\Units\Test;

class FraManager extends Test
{

    public function beforeTestMethod($method)
    {
        $this->em      = new \Mock\Doctrine\ORM\EntityManager();
        $this->fra     = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->filter  = new \Mock\Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface();
        $this->manager = new FraManagerTested($this->em, $this->filter);

        $this->mockGenerator->orphanize('__construct');
        $this->repository = new \Mock\Doctrine\ORM\EntityRepository();
        $this->calling($this->em)->getRepository = $this->repository;
    }

    public function testConstructor()
    {
        $this->object(new FraManagerTested($this->em, $this->filter));
    }

    public function testFindByUser()
    {
        $this->calling($this->repository)->findBy = array();
        $this->manager->findByUser($user = new \Mock\Asbo\WhosWhoBundle\Model\FraUserInterface());

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findBy')
                    ->withIdenticalArguments(array('user' => $user))
                    ->once();
    }

    public function testFindAll()
    {
        $this->calling($this->repository)->findAll = array();
        $this->manager->findAll();

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findAll')
                    ->once();
    }

    public function testCreateFra()
    {
        $this->object($this->manager->create())
                ->isInstanceOf('\Asbo\WhosWhoBundle\Entity\Fra');
    }

    public function testSave()
    {
        $this->manager->save($this->fra);

        $this->mock($this->em)
                ->call('persist')
                    ->withIdenticalArguments($this->fra)
                    ->once()
                ->call('flush')
                    ->once();
    }

    public function testSaveMultiple()
    {
        $fras = array(
            clone $this->fra,
            clone $this->fra,
            clone $this->fra,
            clone $this->fra,
            clone $this->fra,
        );

        $this->manager->saveMultiple($fras);

        $this->mock($this->em)
                ->call('persist')
                    ->withAnyArguments()
                    ->exactly(count($fras))
                ->call('flush')
                    ->once();
    }
}
