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

use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\Address;
use Asbo\WhosWhoBundle\Doctrine\AbstractManager;

/**
 * Address manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AddressManager extends AbstractManager
{
    /**
     * Find an address by fra
     *
     * @param  Fra $fra
     * @return Address[]
     */
    public function findByFra(Fra $fra)
    {
        return $this->repository->findBy(array('fra' => $fra));
    }

    /**
     * Find all addresses
     *
     * @return object[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
