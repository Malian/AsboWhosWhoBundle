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
use Symfony\Component\Intl\Intl;
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Represent a Phone Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__phone")
 * @ORM\Entity()
 */
class Phone
{
    /**
     * Type Phone
     */
    const TYPE_PRIVEE  = 0;
    const TYPE_PARENTS = 1;
    const TYPE_KOT     = 2;
    const TYPE_BUREAU  = 3;
    const TYPE_FAX     = 4;
    const TYPE_GSM     = 5;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $number
     *
     * @ORM\Column(name="number", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(min="8", max="20")
     */
    private $number;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getTypeCallbackValidation")
     */
    private $type;

    /**
     * @var string country
     *
     * @ORM\Column(name="country", type="string", length=10)
     * @Assert\Country
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setType(static::TYPE_PRIVEE);
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
     * Set number
     *
     * @param string $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
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
     * Set country
     *
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get contry
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get Country Code
     *
     * @param null|string $locale
     *
     * @return string
     * @todo: Je suis pas fan de cette manière de faire
     */
    public function getCountryCode($locale = null)
    {
        if ($locale === null) {
            $locale = \Locale::getDefault();
        }

        $countries = Intl::getRegionBundle()->getCountryNames($locale);

        return $countries[$this->getCountry()];
    }

    /**
     * Set fra
     *
     * @param Fra $fra
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
     * Get type phone list number
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_PRIVEE  => 'Privée',
            self::TYPE_PARENTS => 'Parents',
            self::TYPE_KOT     => 'Kot',
            self::TYPE_BUREAU  => 'Bureau',
            self::TYPE_FAX     => 'Fax',
            self::TYPE_GSM     => 'GSM',
        );
    }

    /**
     * Get type code
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
        return (string) $this->number;
    }
}
