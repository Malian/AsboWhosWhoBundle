<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;

/**
 * Validates an anno from ASBO
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AnnoValidator extends ConstraintValidator
{
    protected $annoManipulator;

    /**
     * @param AnnoManipulator $manipulator
     */
    public function __construct(AnnoManipulator $manipulator)
    {
        $this->annoManipulator = $manipulator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->annoManipulator->isValid($value) && "" !== $value && null !== $value) {
            $this->context->addViolation($constraint->message, array('%anno%' => $value));
        }
    }
}
