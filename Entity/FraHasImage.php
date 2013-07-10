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
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;

/**
 * Represent a link between a fra and an image entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__fra_image")
 * @ORM\Entity()
 */
class FraHasImage
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", cascade={"persist"}, inversedBy="fraHasImages")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $fra;

    /**
     * @var Asbo\UserBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Model\FraImageInterface", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $image;

    /**
     * @var $anno $anno
     *
     * @ORM\Column(name="anno", type="integer")
     * @Anno
     */
    private $anno;

    /**
     * @var boolean $principal
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     */
    private $principal;

    /**
     * Set fra
     *
     * @param  \Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return UserHasFra
     */
    public function setFra(\Asbo\WhosWhoBundle\Entity\Fra $fra)
    {
        $this->fra = $fra;

        return $this;
    }

    /**
     * Get fra
     *
     * @return \Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Set user
     *
     * @param  Asbo\CoreBundle\Entity\Media $image
     * @return UserHasFra
     */
    public function setImage(\Asbo\CoreBundle\Entity\Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Asbo\CoreBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
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
     * Set anno
     *
     * @param integer $anno
     * @return $this
     */
    public function setAnno($anno = null)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set principal
     *
     * @param  boolean     $principal
     * @return FraHasImage
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Is the principal image
     *
     * @return Boolean
     */
    public function isPrincipal()
    {
        return $this->principal == true;
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return (string) 'Image: #'.$this->getImage()->getId();
    }
}
