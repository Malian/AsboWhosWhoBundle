<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Form\DataTransformer;

use Asbo\WhosWhoBundle\Tests\Units;
use Asbo\WhosWhoBundle\Form\DataTransformer\StringToAnnoTransformer as StringToAnnoTransformerTested;

class StringToAnnoTransformer extends Units\Test
{
    public function testTransformDatetime()
    {
        $converter = new StringToAnnoTransformerTested;

        $this->array($converter->transform($date = new \DateTime()))
                ->hasSize(2)
                ->hasKeys(array('type', 'date'))
                ->containsValues(array(1, $date->format('Y')));
    }

    public function testTransformInteger()
    {
        $converter = new StringToAnnoTransformerTested;

        $this->array($converter->transform($anno = (int) uniqid()))
                ->hasSize(2)
                ->hasKeys(array('type', 'date'))
                ->containsValues(array(0, $anno));
    }

    public function testReverseTransformDatetime()
    {
        $converter = new StringToAnnoTransformerTested;
        $anno      = array('type' => 1, 'date' => $this->faker->datetime()->format('Y'));

        $this->datetime($converter->reverseTransform($anno))->hasYear($anno['date']);
    }

    public function testReverseTransformInteger()
    {
        $converter = new StringToAnnoTransformerTested;
        $anno      = array('type' => 0, 'date' => (int) uniqid());

        $this->integer($converter->reverseTransform($anno))->isEqualTo($anno['date']);
    }
}
