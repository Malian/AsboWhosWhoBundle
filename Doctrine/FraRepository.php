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

/**
 * Fra Entity Repository
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getQueryBuilder()->getQuery()->getResult();
    }

    protected function getQueryBuilder()
    {
        $qb = parent::getQueryBuilder()
            ->select('fra, fraHasUser, user, fraHasImage, image, fraHasPost, post, address, diploma, email, externalPost, family, job, phone, rank')
            ->leftJoin('fra.fraHasUsers', 'fraHasUser')
            ->leftJoin('fraHasUser.user', 'user')
            ->leftJoin('fra.fraHasImages', 'fraHasImage')
            ->leftJoin('fraHasImage.image', 'image')
            ->leftJoin('fra.fraHasPosts', 'fraHasPost')
            ->leftJoin('fraHasPost.post', 'post')
            ->leftJoin('fra.addresses', 'address')
            ->leftJoin('fra.diplomas', 'diploma')
            ->leftJoin('fra.emails', 'email')
            ->leftJoin('fra.externalPosts', 'externalPost')
            ->leftJoin('fra.families', 'family')
            ->leftJoin('fra.jobs', 'job')
            ->leftJoin('fra.phones', 'phone')
            ->leftJoin('fra.ranks', 'rank')
        ;

        return $qb;
    }

    protected function getAlias()
    {
        return 'fra';
    }
}
