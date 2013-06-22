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

use Asbo\WhosWhoBundle\Entity\FraHasImage as FraHasImageTested;
use Asbo\WhosWhoBundle\Tests\Units;

/**
 * @ignore on
 */
class FraHasImage extends Units\Test
{

    public function beforeTestMethod($method)
    {
        $this->instance = new FraHasImageTested;
    }

    public function testInit()
    {
        $fraHasImage = new FraHasImageTested;

        $this->variable($fraHasImage->getId())->isNull();
        $this->variable($fraHasImage->getFra())->isNull();
        $this->variable($fraHasImage->getImage())->isNull();
        $this->variable($fraHasImage->getAnno())->isNull();
        $this->boolean($fraHasImage->isPrincipal())->isFalse();
    }

    public function testToString()
    {
        $fraHasImage = $this->instance;
        $fraHasImage->setImage($image = $this->createImageMock($id = (int) uniqid()));

        $this->castToString($fraHasImage)
                ->isEqualTo('Image: #'.$id);
    }

    public function testSetFra()
    {
        $fraHasImage = $this->instance;

        $this->object($fraHasImage->setFra($fra = $this->createFraMock(1)))->isIdenticalTo($fraHasImage);
        $this->object($fraHasImage->getFra())->isIdenticalTo($fra);
    }

    public function testSetImageNull()
    {
        $fraHasImage = $this->instance;

        $this->object($this->instance->setImage($image = $this->createImageMock(1)))->isIdenticalTo($fraHasImage);
        $this->object($this->instance->getImage())->isIdenticalTo($image);
    }

    public function testGetSetAnno()
    {
        $fraHasImage = $this->instance;

        $this->variable($fraHasImage->getAnno())->isNull();
        $this->object($fraHasImage->setAnno($anno = (int) uniqid()))->isIdenticalTo($fraHasImage);
        $this->integer($fraHasImage->getAnno())->isEqualTo($anno);
        $this->object($fraHasImage->setAnno())->isIdenticalTo($fraHasImage);
        $this->variable($fraHasImage->getAnno())->isNull();
    }

    public function testPrincipal()
    {
        $fraHasImage = $this->instance;

        $fraHasImage->setPrincipal(true);
        $this->boolean($fraHasImage->isPrincipal())->isTrue();

        $fraHasImage->setPrincipal(false);
        $this->boolean($fraHasImage->isPrincipal())->isFalse();
    }

    protected function createFraMock($id)
    {
        $fraHasImage                        = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($fraHasImage)->getId = $id;

        return $fraHasImage;
    }

    protected function createImageMock($id)
    {
        $image                              = new \Mock\Asbo\MediaBundle\Entity\Media();
        $this->calling($image)->getId       = $id;

        return $image;
    }
}
