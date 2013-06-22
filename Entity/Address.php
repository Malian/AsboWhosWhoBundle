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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Asbo\WhosWhoBundle\Model\AbstractGMap;
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Represent an Address Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__address")
 * @ORM\Entity()
 */
class Address extends AbstractGMap
{

    const TYPE_PRIVEE  = 0;
    const TYPE_KOT     = 1;
    const TYPE_PARENTS = 2;
    const TYPE_BOULOT  = 3;
    const TYPE_AUTRE   = 4;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getTypeCallbackValidation")
     */
    private $type;

    /**
     * @var boolean $principal
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     * @Assert\Type(type="bool")
     */
    private $principal;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

    public function __construct()
    {
        $this->setType(static::TYPE_AUTRE);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     * @return $this
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Is Princpal Adress
     *
     * @return boolean
     */
    public function isPrincipal()
    {
        return true === $this->principal;
    }

    /**
     * Set fra
     *
     * @param Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return $this
     */
    public function setFra(Fra $fra)
    {
        $this->fra = $fra;

        return $this;
    }

    /**
     * Get fra
     *
     * @return Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Get TypeList
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_PRIVEE  => 'Privée',
            self::TYPE_KOT     => 'Kot',
            self::TYPE_PARENTS => 'Parents',
            self::TYPE_BOULOT  => 'Boulot',
            self::TYPE_AUTRE   => 'Autre',
        );
    }

    /**
     * Get Type Code
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        $type = self::getTypes();

        return isset($type[$this->getType()]) ? $type[$this->getType()] : null;
    }

    /**
     * Callback Validation
     *
     * @return array
     */
    public static function getTypeCallbackValidation()
    {
        return array_keys(self::getTypes());
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getAddress();
    }
}
