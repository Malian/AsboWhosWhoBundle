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

/**
 * External Post
 *
 * @ORM\Table(name="ww__externalPost")
 * @ORM\Entity()
 */
class ExternalPost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $where;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBegin", type="date")
     * @Assert\Date()
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEnd;

    /**
     * Asbo\WhosWhoBundle\Entity\Fra $fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="externalPosts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

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
     * Set where
     *
     * @param string $where
     * @return $this
     */
    public function setWhere($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * Get where
     *
     * @return string
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return $this
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return $this
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set fra
     *
     * @param Fra $fra
     *
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
     * @return Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Is a current external post ?
     *
     * @return boolean
     */
    public function isCurrent()
    {
        return (null === $this->dateEnd);
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getPosition() . ' in ' . $this->getWhere();
    }

    /**
     * @Assert\True(message = "La date de départ doit être inférieur ou égale à la date d'arrivée")
     */
    public function isDateBeginLessThanDateEnd()
    {
        return ($this->dateBegin <= $this->dateEnd || $this->isCurrent());
    }
}
