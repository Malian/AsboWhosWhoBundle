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
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Represent a Family Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__family")
 * @ORM\Entity()
 * @todo : Refactoriser tout ça. Si untel est le fil d'un autre alors l'autre est aussi le père...
 */
class Family
{
    /**
     * Type Family Link
     */
    const TYPE_ENFANT   = 0;
    const TYPE_AMI      = 1;
    const TYPE_FIANCE   = 2;
    const TYPE_CONJOINT = 3;
    const TYPE_AUTRE    = 4;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=true)
     */
    private $lastname;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=true)
     */
    private $firstname;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getTypeCallbackValidation")
     */
    private $type;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="families")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $link;

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
     * Set lastname
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        if (null !== $this->getLink()) {
            return $this->getLink()->getLastname();
        }

        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        if (null !== $this->getLink()) {
            return $this->getLink()->getFirstname();
        }

        return $this->firstname;
    }

    /**
     * Set date
     *
     * @param date $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Get link
     *
     * @return Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Get fra
     *
     * @return Asbo\WhosWhoBundle\Entity\Fra
     * @return $this
     */
    public function setLink(\Asbo\WhosWhoBundle\Entity\Fra $link = null)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get Family type link list
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_ENFANT   => 'Enfant',
            self::TYPE_AMI      => 'Ami(e)',
            self::TYPE_FIANCE   => 'Fiancé(e)',
            self::TYPE_CONJOINT => 'Conjoint(e)',
            self::TYPE_AUTRE    => 'Autre'
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
     * Return if the member of family is valid
     *
     * @return boolean
     * @Assert\True(message = "Il faut soit donner un nom et un prénom, soit définir un lien avec un fra existant")
     */
    public function isValid()
    {
        if (empty($this->link) && (empty($this->firstname) || empty($this->lastname))) {
            return false;
        }

        return true;
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        if (empty($this->link)) {
            return $this->firstname.' '.$this->lastname;
        }

        return (string) $this->link;
    }
}
