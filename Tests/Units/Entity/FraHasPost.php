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

use Asbo\WhosWhoBundle\Entity\FraHasPost as FraHasPostTest;
use Asbo\WhosWhoBundle\Tests\Units;

class FraHasPost extends Units\Test
{
    public function testInit()
    {
        $fraHasPost = new FraHasPostTest;

        $this->variable($fraHasPost->getId())->isNull();
        $this->variable($fraHasPost->getFra())->isNull();
        $this->variable($fraHasPost->getPost())->isNull();
    }

    public function testToString()
    {
        $fraHasPost = new FraHasPostTest;

        $this->castToString($fraHasPost)
                ->isEqualTo('');

        $fraHasPost->setPost($this->createPostMock(1, $post = 'Censor'));

        $this->castToString($fraHasPost)->isEqualTo($post);
    }

    public function testSetFra()
    {
        $fraHasPost = new FraHasPostTest;

        $this->object($fraHasPost->setFra($fra = $this->createFraMock(1)))->isIdenticalTo($fraHasPost);
        $this->object($fraHasPost->getFra())->isIdenticalTo($fra);
    }

    public function testSetPost()
    {
        $fraHasPost = new FraHasPostTest;

        $this->object($fraHasPost->setPost($post = $this->createPostMock(1)))->isIdenticalTo($fraHasPost);
        $this->object($fraHasPost->getPost())->isIdenticalTo($post);
    }

    public function testGetSetAnno()
    {
        $fraHasPost = new FraHasPostTest;

        $this->variable($fraHasPost->getAnno())->isNull();
        $this->object($fraHasPost->setCivilYear(new \DateTime()));
        $this->object($fraHasPost->setAnno($anno = (int) uniqid()))->isIdenticalTo($fraHasPost);

        $this->integer($fraHasPost->getAnno())->isEqualTo($anno);
        $this->variable($fraHasPost->getCivilYear())->isNull();

        $this->object($fraHasPost->setAnno())->isIdenticalTo($fraHasPost);
        $this->variable($fraHasPost->getAnno())->isNull();
    }

    public function testGetSetCivilYear()
    {
        $fraHasPost = new FraHasPostTest;

        $this->variable($fraHasPost->getCivilYear())->isNull();
        $this->object($fraHasPost->setAnno((int) uniqid()));

        $this->object($fraHasPost->setCivilYear($date = new \DateTime()))->isIdenticalTo($fraHasPost);
        $this->datetime($fraHasPost->getCivilYear())->isIdenticalTo($date);
        $this->variable($fraHasPost->getAnno())->isNull();

        $this->object($fraHasPost->setCivilYear())->isIdenticalTo($fraHasPost);
        $this->variable($fraHasPost->getCivilYear())->isNull();
    }

    public function testGetDate()
    {
        $fraHasPost = new FraHasPostTest;

        $this->variable($fraHasPost->getDate())->isNull();
        $this->variable($fraHasPost->getDate())->isEqualTo($fraHasPost->getAnno());

        $this->datetime($fraHasPost->setCivilYear($date = new \DateTime())->getDate())->hasYear($date->format('Y'));
        $this->integer($fraHasPost->setAnno($anno = (int) uniqid())->getDate())->isEqualTo($anno);
    }

    public function testSetDateWithDateTime()
    {
        $fraHasPost = new FraHasPostTest;
        $fraHasPost->setAnno(uniqid());

        $this->object($fraHasPost->setDate($date = new \DateTime()))->isIdenticalTo($fraHasPost);
        $this->datetime($fraHasPost->getDate())->hasYear($date->format('Y'));
        $this->variable($fraHasPost->getAnno())->isNull();
        $this->datetime($fraHasPost->getCivilYear())->isIdenticalTo($date);
    }

    public function testSetDateWithAnno()
    {
        $fraHasPost = new FraHasPostTest;
        $fraHasPost->setCivilYear(new \DateTime());

        $this->object($fraHasPost->setDate($anno = (int) uniqid()))->isIdenticalTo($fraHasPost);
        $this->integer($fraHasPost->getDate())->isEqualTo($anno);
        $this->variable($fraHasPost->getCivilYear())->isNull();
        $this->integer($fraHasPost->getAnno())->isIdenticalTo($anno);
    }

    protected function createFraMock($id)
    {
        $fraHasPost                        = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($fraHasPost)->getId = $id;

        return $fraHasPost;
    }

    protected function createPostMock($id, $name = null)
    {
        $post                              = new \Mock\Asbo\WhosWhoBundle\Entity\Post();
        $this->calling($post)->getId       = $id;
        $this->calling($post)->__toString  = $name;

        return $post;
    }
}
