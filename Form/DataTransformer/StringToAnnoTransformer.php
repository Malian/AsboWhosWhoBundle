<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * String to anno transformer
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class StringToAnnoTransformer implements DataTransformerInterface
{
    /**
     * Transforms an object ($date) to an array option
     *
     * @param  \Datetime|null $date
     * @return array
     */
    public function transform($date)
    {
        if ($date instanceof \DateTime) {
            return array('type' => 1, 'date' => $date->format('Y'));
        } else {
            return array('type' => 0, 'date' => $date);
        }
    }

    /**
     * Transforms an array options to an number|date
     *
     * @param  array          $anno
     * @return \DateTime|null
     */
    public function reverseTransform($anno)
    {
        if ($anno['type'] == 1) {
            // Fix bug quand la date est juste 2002 par exemple il transforme en 20h02 et pas en l'année.
            // Pour modifier ce comportement on fixe la date au premier janvier
            return new \Datetime($anno['date'].'-01-01');
        } else {
            return (int) $anno['date'];
        }
    }
}
