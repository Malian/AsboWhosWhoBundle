<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units;

use Closure;
use mageekguy\atoum;
use mageekguy\atoum\annotations\extractor;
use mageekguy\atoum\asserter\generator;
use mageekguy\atoum\test\assertion\manager;

abstract class Test extends atoum\test
{
    public function __construct(
        adapter $adapter = null,
        extractor $annotationExtractor = null,
        generator $asserterGenerator = null,
        manager $assertionManager = null,
        Closure $reflectionClassFactory = null
    ) {
        $this->setTestNamespace('Tests\Units');
        parent::__construct($adapter, $annotationExtractor, $asserterGenerator, $assertionManager, $reflectionClassFactory);
    }

    public function setAssertionManager(atoum\test\assertion\manager $assertionManager = null)
    {
        $self = $this;

        $returnFaker = function ($locale = 'en_US') use ($self) {
            return $self->getFaker($locale);
        };

        parent::setAssertionManager($assertionManager)
            ->getAssertionManager()
                ->setHandler('faker', $returnFaker);

        return $this;
    }

    public function getFaker($locale = 'en_US')
    {
        return \Faker\Factory::create($locale);
    }
}
