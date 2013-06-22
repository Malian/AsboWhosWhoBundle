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

use Asbo\WhosWhoBundle\Entity\Diploma as DiplomaTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Diploma extends Units\Test
{

    public function testCreate()
    {
        $diploma = new DiplomaTest;

        $this->variable($diploma->getId())->isNull();
        $this->variable($diploma->getName())->isNull();
        $this->variable($diploma->getSpecialty())->isNull();
        $this->variable($diploma->getInstitution())->isNull();
        $this->variable($diploma->getGraduatedAt())->isNull();
        $this->variable($diploma->getFra())->isNull();
        $this->boolean($diploma->isCurrent())->isTrue();
    }

    public function testDiploma()
    {
        $diploma     = new DiplomaTest;
        $name        = $this->faker->sentence();
        $specialty   = $this->faker->word();
        $institution = $this->faker->company();
        $graduatedAt = $this->faker->dateTimeBetween('-25 years', 'now');

        $this->object($diploma->setName($name))->isIdenticalTo($diploma);
        $this->object($diploma->setSpecialty($specialty))->isIdenticalTo($diploma);
        $this->object($diploma->setInstitution($institution))->isIdenticalTo($diploma);
        $this->object($diploma->setGraduatedAt($graduatedAt))->isIdenticalTo($diploma);

        $this->string($diploma->getName())->isEqualTo($name);
        $this->string($diploma->getSpecialty())->isEqualTo($specialty);
        $this->string($diploma->getInstitution())->isEqualTo($institution);
        $this->boolean($diploma->isCurrent())->isFalse();

        $this->datetime($diploma->getGraduatedAt())->isEqualTo($graduatedAt);

        $this->variable($diploma->setName(null)->getName())->isNull();
        $this->variable($diploma->setSpecialty(null)->getSpecialty())->isNull();
        $this->variable($diploma->setInstitution(null)->getInstitution())->isNull();
        $this->variable($diploma->setGraduatedAt(null)->getGraduatedAt())->isNull();
        $this->boolean($diploma->isCurrent())->isTrue();
    }

    public function testToString()
    {
        $diploma     = new DiplomaTest;

        $this->castToString($diploma)
                ->isEqualTo(' @ ');

        $name        = $this->faker->sentence();
        $institution = $this->faker->word();

        $diploma->setName($name);
        $diploma->setInstitution($institution);

        $this->castToString($diploma)->isEqualTo($name.' @ '.$institution);
    }

    public function testFra()
    {
        $diploma = new DiplomaTest;
        $fra     = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = 140);
        $this->object($diploma->setFra($fra))->isIdenticalTo($diploma);
        $this->object($diploma->getFra())->isIdenticalTo($fra);
        $this->integer($diploma->getFra()->getId())->isEqualTo($id);
    }
}
