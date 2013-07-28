<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Doctrine;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;

/**
 * Entity Repository
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class EntityRepository extends BaseEntityRepository
{
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    protected function getCollectionQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    protected function getAlias()
    {
        return 'o';
    }
}
