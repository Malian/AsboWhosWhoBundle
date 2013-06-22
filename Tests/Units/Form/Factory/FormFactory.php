<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Form\Factory;

use Asbo\WhosWhoBundle\Tests\Units;
use Asbo\WhosWhoBundle\Form\Factory\FormFactory as FormFactoryTested;

class FormFactory extends Units\Test
{
    public function testConstruct()
    {
        $factoryMock = new \Mock\Symfony\Component\Form\FormFactoryInterface();
        $name        = $this->faker->word();
        $type        = $this->faker->word();

        $factory = new FormFactoryTested($factoryMock, $name, $type);

        $this->mock($factoryMock)
                ->call('createNamed')
                    ->never();
    }

    public function testCreateForm()
    {
        $factoryMock = new \Mock\Symfony\Component\Form\FormFactoryInterface();
        $name        = $this->faker->word();
        $type        = $this->faker->word();
        $validation  = $this->faker->words(3);

        $factory = new FormFactoryTested($factoryMock, $name, $type, $validation);
        $factory->createForm();

        $this->mock($factoryMock)
                ->call('createNamed')
                    ->withIdenticalArguments($name, $type, null, array('validation_groups' => $validation))
                    ->once();

        $factory = new FormFactoryTested($factoryMock, $name, $type);
        $factory->createForm();

        $this->mock($factoryMock)
                ->call('createNamed')
                    ->withIdenticalArguments($name, $type, null, array('validation_groups' => null))
                    ->once();
    }
}
