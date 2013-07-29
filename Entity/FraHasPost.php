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
use Asbo\WhosWhoBundle\Entity\Post;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;

/**
 * Represent a link between a fra and post entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__fra_post")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Doctrine\FraHasPostRepository")
 */
class FraHasPost
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
     * @var integer $anno
     *
     * @ORM\Column(name="anno", type="smallint", nullable=true)
     * @Assert\Type(type="integer")
     * @Anno
     */
    private $anno;

    /**
     * @var \Datetime $civilyear
     *
     * @ORM\Column(name="civilyear", type="date", nullable=true)
     * @Assert\Type(type="datetime")
     */
    private $civilyear;

    /**
     * @var Post $post
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Post")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $post;

    /**
     * @var Fra $fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="fraHasPosts")
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
     * Set date
     *
     * @param string|\Datetime $date
     * @return $this
     * @todo Vérifier le type de la date
     */
    public function setDate($date)
    {
        if ($date instanceof \DateTime) {
            $this->setCivilYear($date);
        } else {
            $this->setAnno($date);
        }

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     * @todo Vérifier le type de la date
     */
    public function getDate()
    {
        if ($this->getCivilYear() instanceof \DateTime) {
            return $this->getCivilYear();
        } else {
            return $this->getAnno();
        }
    }

    /**
     * Set anno
     *
     * @param integer $anno
     * @return $this
     */
    public function setAnno($anno = null)
    {
        $this->anno      = $anno;
        $this->civilyear = null;

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
     * Set civilyear
     *
     * @param \Datetime $civilyear
     * @return $this
     */
    public function setCivilYear(\Datetime $civilyear = null)
    {
        $this->civilyear = $civilyear;
        $this->anno      = null;

        return $this;
    }

    /**
     * Get civilyear
     *
     * @return \Datetime
     */
    public function getCivilYear()
    {
        return $this->civilyear;
    }

    /**
     * Set post
     *
     * @param \Asbo\WhosWhoBundle\Entity\Post $post
     *
     * @return $this
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Asbo\WhosWhoBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set fra
     *
     * @param \Asbo\WhosWhoBundle\Entity\Fra $fra
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
     * @return \Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getPost();
    }
}
