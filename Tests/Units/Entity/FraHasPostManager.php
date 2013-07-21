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

use Asbo\WhosWhoBundle\Entity\FraHasPostManager as FraHasPostManagerTested;
use Asbo\WhosWhoBundle\Tests\Units;

class FraHasPostManager extends Units\Test
{

    public function beforeTestMethod($method)
    {
        $this->em             = new \Mock\Doctrine\ORM\EntityManager();
        $this->fraHasPost     = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasPost();
        $this->manager        = new FraHasPostManagerTested($this->em);

        $this->mockGenerator->orphanize('__construct');
        $this->repository = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasPostRepository();
        $this->calling($this->em)->getRepository = $this->repository;
    }

    public function testConstructor()
    {
        $this->object(new FraHasPostManagerTested($this->em));
    }

    public function testGetRepository()
    {
        $this->manager->getRepository();

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();
    }

    public function testFindByTypes()
    {
        $this->calling($this->repository)->findByTypes = array();
        $this->manager->findByTypes($types = array(uniqid() ,uniqid()));

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findByTypes')
                    ->withIdenticalArguments($types)
                    ->once();
    }

    public function testFindByTypesString()
    {
        $this->calling($this->repository)->findByTypes = array();
        $this->manager->findByTypes($type = uniqid());

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findByTypes')
                    ->withIdenticalArguments(array($type))
                    ->once();
    }

    public function testFindByTypesOther()
    {
        $manager = $this->manager;

        $this->exception(
            function () use ($manager) {
                $manager->findByTypes($type = new \StdClass());
            }
        );
    }

    public function testFindByTypesAndYear()
    {
        $this->calling($this->repository)->findByTypesAndYear = array();
        $this->manager->findByTypesAndYear($types = array(uniqid() ,uniqid()), $year = uniqid());

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findByTypesAndYear')
                    ->withIdenticalArguments($types, $year)
                    ->once();
    }

    public function testFindByTypesAndYearString()
    {
        $this->calling($this->repository)->findByTypesAndYear = array();
        $this->manager->findByTypesAndYear($type = uniqid(), $year = uniqid());

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findByTypesAndYear')
                    ->withIdenticalArguments(array($type), $year)
                    ->once();
    }

    public function testFindByTypesAndYearOther()
    {
        $manager = $this->manager;

        $this->exception(
            function () use ($manager) {
                $manager->findByTypesAndYear($type = new \StdClass(), uniqid());
            }
        );
    }

    public function testFindByFra()
    {
        $this->calling($this->repository)->findBy = array();
        $this->manager->findByFra($fra = new \Mock\Asbo\WhosWhoBundle\Entity\Fra());

        $this->mock($this->em)
                ->call('getRepository')
                    ->once();

        $this->mock($this->repository)
                ->call('findBy')
                    ->withIdenticalArguments(array('fra' => $fra))
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

    public function testCreate()
    {
        $this->object($this->manager->create())
                ->isInstanceOf('\Asbo\WhosWhoBundle\Entity\FraHasPost');
    }

    public function testSave()
    {
        $this->manager->save($this->fraHasPost);

        $this->mock($this->em)
                ->call('persist')
                    ->withIdenticalArguments($this->fraHasPost)
                    ->once()
                ->call('flush')
                    ->once();
    }
}
