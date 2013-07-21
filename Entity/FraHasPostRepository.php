<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * FraHasPost repository
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraHasPostRepository extends EntityRepository
{
    /**
     * @param array $types
     *
     * @return FraHasPost[]
     */
    public function findByTypes(array $types)
    {

        $qb = $this->createQueryBuilder('l')
                     ->leftJoin('l.post', 'p')
                     ->addSelect('p')
                     ->orderBy('l.anno')
                     ->addOrderBy('p.type');

        foreach ($types as $type) {
            $qb->orWhere('p.type = '.$type);
        }

        $qb = $this->joinFra($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array   $types
     * @param integer $anno
     *
     * @return FraHasPost[]
     */
    public function findByTypesAndYear(array $types, $anno)
    {
        $qb = $this->createQueryBuilder('l')
                     ->leftJoin('l.post', 'p')
                     ->addSelect('p')
                     ->addOrderBy('p.type');

        foreach ($types as $type) {
            $qb->orWhere('p.type = '.$type);
        }

        $qb->andWhere('l.anno = :anno')->setParameter('anno', $anno);

        $qb = $this->joinFra($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return QueryBuilder
     */
    private function joinFra(QueryBuilder $qb)
    {
        $qb->leftJoin('l.fra', 'f')
           ->addSelect('f')
           ->leftJoin('f.fraHasImages', 'x')
           ->addSelect('x')
           ->leftJoin('x.image', 'i')
           ->addSelect('i');

        return $qb;
    }
}
