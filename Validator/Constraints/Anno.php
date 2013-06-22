<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Metadata for the AnnoValidator.
 *
 * @Annotation
 */
class Anno extends Constraint
{
    /**
     * {@inheritDoc}
     */
    public $message = 'L\'anno "%anno%" n\'est pas une anno valide de l\'ASBO';

    /**
     * {@inheritDoc}
     */
    public function validatedBy()
    {
        return 'asbo_whoswho_anno_validator';
    }
}
