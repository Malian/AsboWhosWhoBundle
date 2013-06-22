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

use Asbo\WhosWhoBundle\Entity\Job as JobTest;
use Asbo\WhosWhoBundle\Tests\Units;

class Job extends Units\Test
{

    public function testCreate()
    {
        $job = new JobTest;

        $this->variable($job->getId())->isNull();
        $this->variable($job->getCompany())->isNull();
        $this->variable($job->getSector())->isNull();
        $this->variable($job->getPosition())->isNull();
        $this->variable($job->getDateBegin())->isNull();
        $this->variable($job->getDateEnd())->isNull();
        $this->variable($job->getFra())->isNull();
        $this->boolean($job->isCurrent())->isTrue();
    }

    public function testJob()
    {
        $job      = new JobTest;
        $company   = $this->faker->company();
        $sector    = $this->faker->word();
        $position  = $this->faker->catchPhrase();
        $dateBegin = $this->faker->dateTimeBetween('-30 years', 'now');
        $dateEnd   = $this->faker->dateTimeBetween($dateBegin, 'now');

        $this->object($job->setCompany($company))->isIdenticalTo($job);
        $this->object($job->setSector($sector))->isIdenticalTo($job);
        $this->object($job->setPosition($position))->isIdenticalTo($job);
        $this->object($job->setDateBegin($dateBegin))->isIdenticalTo($job);
        $this->object($job->setDateEnd($dateEnd))->isIdenticalTo($job);

        $this->string($job->getCompany())->isEqualTo($company);
        $this->string($job->getSector())->isEqualTo($sector);
        $this->string($job->getPosition())->isEqualTo($position);
        $this->datetime($job->getDateBegin())->isEqualTo($dateBegin);
        $this->datetime($job->getDateEnd())->isEqualTo($dateEnd);
        $this->boolean($job->isCurrent())->isFalse();

        $this->variable($job->setCompany(null)->getCompany())->isNull();
        $this->variable($job->setSector(null)->getSector())->isNull();
        $this->variable($job->setPosition(null)->getPosition())->isNull();
        $this->variable($job->setDateBegin(null)->getDateBegin())->isNull();
        $this->variable($job->setDateEnd(null)->getDateEnd())->isNull();

        $this->boolean($job->isCurrent())->isTrue();
    }

    public function testToString()
    {
        $job = new JobTest;

        $this->castToString($job)
                ->isEqualTo(' in ');

        $job->setPosition($position = $this->faker->catchPhrase())
            ->setCompany($company = $this->faker->company());

        $this->castToString($job)->isEqualTo($position. ' in ' .$company);
    }

    public function testFra()
    {
        $job = new JobTest;
        $fra  = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();

        $this->calling($fra)->getId = ($id = $this->faker->randomDigitNotNull());
        $this->object($job->setFra($fra))->isIdenticalTo($job);
        $this->object($job->getFra())->isIdenticalTo($fra);
        $this->integer($job->getFra()->getId())->isEqualTo($id);
    }

    public function testIsDateBeginLessThanDateEnd()
    {
        $job = (new JobTest)->setDateBegin($dateBegin = $this->faker->dateTimeBetween('-30 years', 'now'))
                             ->setDateEnd($this->faker->dateTimeBetween($dateBegin, 'now'));

        $this->boolean($job->isDateBeginLessThanDateEnd())->isTrue();

        $job = (new JobTest)->setDateBegin($dateBegin = $this->faker->dateTimeBetween('-30 years', 'now'))
                             ->setDateEnd($this->faker->dateTimeBetween('-50 years', $dateBegin));

        $this->boolean($job->isDateBeginLessThanDateEnd())->isFalse();
    }
}
