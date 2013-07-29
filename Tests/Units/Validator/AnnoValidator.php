<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Validator;

use Asbo\WhosWhoBundle\Validator\AnnoValidator as AnnoValidatorTested;
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;
use Asbo\WhosWhoBundle\Tests\Units;

class AnnoValidator extends Units\Test
{

    public function testClass()
    {
        $this->testedClass->extends('Symfony\Component\Validator\ConstraintValidator');
    }

    public function testValidateWithInvalidValue()
    {
        $this->mockGenerator->orphanize('__construct');
        $contextMock = new \Mock\Symfony\Component\Validator\ExecutionContext();

        $this->calling($contextMock)->addViolation = function () {
        };

        $validator = new AnnoValidatorTested();
        $validator->initialize($contextMock);
        $validator->validate(-1, new Anno);

        $this->mock($contextMock)
                ->call('addViolation')
                    ->once();
    }

    /**
     * @dataProvider validValue
     */
    public function testValidateWithValidValue($value)
    {
        $this->mockGenerator->orphanize('__construct');
        $this->mockGenerator->shuntParentClassCalls();
        $contextMock = new \Mock\Symfony\Component\Validator\ExecutionContext();

        $this->calling($contextMock)->addViolation = function () {
        };

        $validator = new AnnoValidatorTested();
        $validator->initialize($contextMock);
        $validator->validate($value, new Anno);

        $this->mock($contextMock)
                ->call('addViolation')
                    ->never();
    }

    protected function validValue()
    {
        return array(
            1,
            "",
            null
        );
    }
}
