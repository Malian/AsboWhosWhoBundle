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
 * Represent an Email Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__email")
 * @ORM\Entity()
 */
class Email
{
    /**
     * Type Email
     */
    const TYPE_PRIVEE = 0;
    const TYPE_BOULOT = 1;
    const TYPE_AUTRE  = 2;
    const TYPE_UCL    = 3;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getEmailTypeCallbackValidation")
     */
    private $type;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="emails")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setType(Email::TYPE_AUTRE);
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
     * Set email
     *
     * @param  string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set type
     *
     * @param  integer $type
     * @return Email
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
     * @param  Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return Email
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
     * Get TypeEmailList
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_PRIVEE => 'Privée',
            self::TYPE_BOULOT => 'Boulot',
            self::TYPE_UCL    => 'UCL',
            self::TYPE_AUTRE  => 'Autre',
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
    public static function getEmailTypeCallbackValidation()
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
        return (string) $this->email;
    }
}
