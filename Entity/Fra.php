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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Asbo\WhosWhoBundle\Entity\Email;
use Asbo\WhosWhoBundle\Entity\Diploma;
use Asbo\WhosWhoBundle\Entity\Phone;
use Asbo\WhosWhoBundle\Entity\Address;
use Asbo\WhosWhoBundle\Entity\Job;
use Asbo\WhosWhoBundle\Entity\Family;
use Asbo\WhosWhoBundle\Entity\ExternalPost;
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;

/**
 * Represent a Fra Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__fra")
 * @ORM\Entity()
 */
class Fra
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
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     */
    private $lastname;

    /**
     * @var string $nickname
     *
     * @ORM\Column(name="nickname", type="string", length=50, nullable=true)
     * @Assert\Length(max=50)
     */
    private $nickname;

    /**
     * @var boolean $gender
     *
     * @ORM\Column(name="gender", type="boolean")
     * @Assert\Choice(choices = {"0", "1"})
     */
    private $gender;

    /**
     * @var \DateTime $bornAt
     *
     * @ORM\Column(name="bornAt", type="date", nullable=true)
     * @Assert\date
     */
    private $bornAt;

    /**
     * @var \DateTime $diedAt
     *
     * @ORM\Column(name="diedAt", type="date", nullable=true)
     * @Assert\date
     */
    private $diedAt;

    /**
     * @var \DateTime $bornIn
     *
     * @ORM\Column(name="bornIn", type="string", length=50, nullable=true)
     */
    private $bornIn;

    /**
     * @var \DateTime $diedIn
     *
     * @ORM\Column(name="diedIn", type="string", length=50, nullable=true)
     */
    private $diedIn;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime $anno
     *
     * @ORM\Column(name="anno", type="integer")
     * @Anno()
     */
    private $anno;

    /**
     * @var boolean $pontif
     *
     * @ORM\Column(name="pontif", type="boolean", nullable=true)
     */
    private $pontif;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(fields={"firstname", "lastname"}, updatable=false, unique=true, separator="")
     */
    private $slug;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection $fraHasUsers
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\FraHasUser", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $fraHasUsers;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Post $fraHasPosts
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\FraHasPost", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $fraHasPosts;

    /**
     * @var Asbo\MediaBundle\Entity\Media $fraHasImages
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\FraHasImage", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $fraHasImages;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Email $emails
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Email", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Email $principalEmail
     *
     * @ORM\OneToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Email")
     */
    private $principalEmail;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Diploma $diplomas
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Diploma", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $diplomas;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Phone $phones
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Phone", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $phones;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Phone $principalPhone
     *
     * @ORM\OneToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Phone")
     */
    private $principalPhone;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Address $addresses
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Address", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $addresses;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Address $principalAddress
     *
     * @ORM\OneToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Address")
     */
    private $principalAddress;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Job $jobs
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Job", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $jobs;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Family $families
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Family", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $families;

    /**
     * @var Asbo\WhosWhoBundle\Entity\ExternalPost $externalPosts
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\ExternalPost", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $externalPosts;

    /**
     * @var array $settings
     *
     * @ORM\Column(name="settings", type="array")
     */
    private $settings = array(
        'whoswho'               => true,
        'pereat'                => true,
        'convoc_externe'        => true,
        'convoc_banquet'        => true,
        'convoc_we'             => true,
        'convoc_ephemerides_q1' => true,
        'convoc_ephemerides_q2' => true
    );

    /**
     * Type Fra
     */
    const TYPE_IMPETRANT     = 0;
    const TYPE_IN_SPE        = 1;
    const TYPE_HONORIS_CAUSA = 2;
    const TYPE_CHEVALIER     = 3;

    /**
     * Status Fra
     */
    const STATUS_TYRO             = 0;
    const STATUS_HONORIS_CAUSA    = 1;
    const STATUS_CAPPELANUS       = 2;
    const STATUS_CHEVALIER        = 3;
    const STATUS_CANDIDATUS       = 4;
    const STATUS_CANDIDAT_HONNEUR = 5;
    const STATUS_XHANTIPPE        = 6;
    const STATUS_SODALES          = 7;
    const STATUS_VETERANUS        = 8;
    const STATUS_IN_SPE           = 9;
    const STATUS_VEXILLARIUS      = 10;

    /**
     * Correspondence Matrix
     */
    protected static $correspondenceMatrix = array(
        self::TYPE_IMPETRANT => array(
            self::STATUS_TYRO             => 1,
            self::STATUS_CAPPELANUS       => 0,
            self::STATUS_CHEVALIER        => 0,
            self::STATUS_CANDIDATUS       => 1,
            self::STATUS_XHANTIPPE        => 0,
            self::STATUS_SODALES          => 0,
            self::STATUS_VETERANUS        => 0,
            self::STATUS_IN_SPE           => 0,
            self::STATUS_VEXILLARIUS      => 0,
            ),
        self::TYPE_IN_SPE => array(
            self::STATUS_TYRO             => 1,
            self::STATUS_CAPPELANUS       => 1,
            self::STATUS_CHEVALIER        => 1,
            self::STATUS_CANDIDATUS       => 1,
            self::STATUS_XHANTIPPE        => 1,
            self::STATUS_SODALES          => 1,
            self::STATUS_VETERANUS        => 1,
            self::STATUS_IN_SPE           => 1,
            self::STATUS_VEXILLARIUS      => 1,
            ),
        self::TYPE_HONORIS_CAUSA => array(
            self::STATUS_TYRO             => 0,
            self::STATUS_CAPPELANUS       => 1,
            self::STATUS_CHEVALIER        => 1,
            self::STATUS_CANDIDATUS       => 0,
            self::STATUS_XHANTIPPE        => 1,
            self::STATUS_SODALES          => 1,
            self::STATUS_VETERANUS        => 1,
            self::STATUS_IN_SPE           => 1,
            self::STATUS_VEXILLARIUS      => 1,
            ),
        self::TYPE_CHEVALIER => array(
            self::STATUS_TYRO             => 0,
            self::STATUS_CAPPELANUS       => 1,
            self::STATUS_CHEVALIER        => 1,
            self::STATUS_CANDIDATUS       => 0,
            self::STATUS_XHANTIPPE        => 1,
            self::STATUS_SODALES          => 1,
            self::STATUS_VETERANUS        => 1,
            self::STATUS_IN_SPE           => 0,
            self::STATUS_VEXILLARIUS      => 1,
            ),
        );

    public function __construct()
    {

        $this->emails        = new ArrayCollection();
        $this->diplomas      = new ArrayCollection();
        $this->phones        = new ArrayCollection();
        $this->addresses     = new ArrayCollection();
        $this->jobs          = new ArrayCollection();
        $this->fraHasUsers   = new ArrayCollection();
        $this->fraHasPosts   = new ArrayCollection();
        $this->fraHasImages  = new ArrayCollection();
        $this->families      = new ArrayCollection();
        $this->externalPosts = new ArrayCollection();

        // Quand on rajoute un fra il y a de forte chance pour qu'il soit
        // Tyro et que ce soit un garçon
        // De plus quand on rajoute un fra en général c'est pour l'anno en cours.
        $this->type   = self::TYPE_IMPETRANT;
        $this->status = self::STATUS_TYRO;
        $this->gender = 0;
        $this->anno   = AnnoManipulator::getCurrentAnno();
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
     * Set id
     * This function is unused.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set firstname
     *
     * @param  string $firstname
     * @return Fra
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
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param  string $lastname
     * @return Fra
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
        return $this->lastname;
    }

    /**
     * Set nickname
     *
     * @param  string $nickname
     * @return string
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set bornAt
     *
     * @param \DateTime $bornAt
     * @return $this
     */
    public function setBornAt($bornAt)
    {
        $this->bornAt = $bornAt;

        return $this;
    }

    /**
     * Get bornAt
     *
     * @return \DateTime
     */
    public function getBornAt()
    {
        return $this->bornAt;
    }

    /**
     * Set diedAt
     *
     * @param \DateTime $diedAt
     * @return $this
     */
    public function setDiedAt($diedAt)
    {
        $this->diedAt = $diedAt;

        return $this;
    }

    /**
     * Get diedAt
     *
     * @return \DateTime
     */
    public function getDiedAt()
    {
        return $this->diedAt;
    }

    /**
     * Set bornIn
     *
     * @param string $bornIn
     * @return $this
     */
    public function setBornIn($bornIn)
    {
        $this->bornIn = $bornIn;

        return $this;
    }

    /**
     * Get bornIn
     *
     * @return string
     */
    public function getBornIn()
    {
        return $this->bornIn;
    }

    /**
     * Set diedIn
     *
     * @param  string $diedIn
     * @return Fra
     */
    public function setDiedIn($diedIn)
    {
        $this->diedIn = $diedIn;

        return $this;
    }

    /**
     * Get diedIn
     *
     * @return string
     */
    public function getDiedIn()
    {
        return $this->diedIn;
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
     * Set status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set anno
     *
     * @param integer $anno
     * @return $this
     */
    public function setAnno($anno)
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
     * Set pontif
     *
     * @param boolean $pontif
     * @return $this
     */
    public function setPontif($pontif)
    {
        $this->pontif = $pontif;

        return $this;
    }

    /**
     * Get pontif
     *
     * @return boolean
     */
    public function isPontif()
    {
        return true == $this->pontif;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Fra
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

     /**
     * {@inheritdoc}
     */
    public function addFraHasUser(FraHasUser $fraHasUser)
    {
        $fraHasUser->setFra($this);

        $this->fraHasUsers->add($fraHasUser);

        return $this;
    }

    /**
     * Remove a link between a fra and an user
     *
     * @param \Asbo\WhosWhoBundle\Entity\FraHasUser $fraHasUser
     */
    public function removeFraHasUser(FraHasUser $fraHasUser)
    {
        $this->fraHasUsers->removeElement($fraHasUser);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFraHasUsers()
    {
        return $this->fraHasUsers;
    }

    /**
     * {@inheritdoc}
     */
    public function getFraHasPosts()
    {
        return $this->fraHasPosts;
    }

    /**
     * {@inheritdoc}
     */
    public function addFraHasPost(FraHasPost $fraHasPost)
    {
        $fraHasPost->setFra($this);

        $this->fraHasPosts->add($fraHasPost);

        return $this;
    }

    /**
     * Remove a link between a fran and a post
     *
     * @param \Asbo\WhosWhoBundle\Entity\FraHasPost $fraHasPost
     */
    public function removeFraHasPost(FraHasPost $fraHasPost)
    {
        $this->fraHasPosts->removeElement($fraHasPost);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFraHasImages()
    {
        return $this->fraHasImages;
    }

    /**
     * {@inheritdoc}
     */
    public function addFraHasImage(FraHasImage $fraHasImage)
    {
        $fraHasImage->setFra($this);

        $this->fraHasImages->add($fraHasImage);

        return $this;
    }

    /**
     * Remove a link between a fra and an image
     *
     * @param \Asbo\WhosWhoBundle\Entity\FraHasImage $fraHasImage
     */
    public function removeFraHasImage(FraHasImage $fraHasImage)
    {
        $this->fraHasImages->removeElement($fraHasImage);

        return $this;
    }

    /**
     * Add a email
     *
     * @param \Asbo\WhosWhoBundle\Entity\Email $email
     */
    public function addEmail(Email $email)
    {
        $email->setFra($this);

        $this->emails->add($email);

        if (null === $this->getPrincipalEmail()) {
            $this->setPrincipalEmail($email);
        }

        return $this;
    }

    /**
     * Remove an email
     *
     * @param \Asbo\WhosWhoBundle\Entity\Email $email
     */
    public function removeEmail(Email $email)
    {
        $this->emails->removeElement($email);

        return $this;
    }

    /**
     * Get emails
     *
     * @return array $emails
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set the principal email 
     *
     * @param \Asbo\WhosWhoBundle\Entity\Email $email
     */
    public function setPrincipalEmail(Email $email = null)
    {
        $this->principalEmail = $email;

        return $this;
    }

    /**
     * Get the principal email 
     *
     * @return \Asbo\WhosWhoBundle\Entity\Email
     */
    public function getPrincipalEmail()
    {
        return $this->principalEmail;
    }

    /**
     * Add a job
     *
     * @param \Asbo\WhosWhoBundle\Entity\Job $job
     */
    public function addJob(Job $job)
    {
        $job->setFra($this);

        $this->jobs->add($job);

        return $this;
    }

    /**
     * Remove an job
     *
     * @param \Asbo\WhosWhoBundle\Entity\Job $job
     */
    public function removeJob(Job $job)
    {
        $this->jobs->removeElement($job);

        return $this;
    }

    /**
     * Get jobs
     *
     * @return array $jobs
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add a diploma
     *
     * @param \Asbo\WhosWhoBundle\Entity\Diploma $diploma
     */
    public function addDiploma(Diploma $diploma)
    {
        $diploma->setFra($this);

        $this->diplomas->add($diploma);

        return $this;
    }

    /**
     * Remove a diploma
     *
     * @param \Asbo\WhosWhoBundle\Entity\Diploma $diploma
     */
    public function removeDiploma(Diploma $diploma)
    {
        $this->diplomas->removeElement($diploma);

        return $this;
    }

    /**
     * Get diplomas
     *
     * @return array $diplomas
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * Remove a member of family
     *
     * @param \Asbo\WhosWhoBundle\Entity\Family $family
     */
    public function removeFamily(Family $family)
    {
        $this->families->removeElement($family);

        return $this;
    }

    /**
     * Add a membre of family
     *
     * @param \Asbo\WhosWhoBundle\Entity\Family $family
     */
    public function addFamily(Family $family)
    {
        $family->setFra($this);

        $this->families->add($family);

        return $this;
    }

    /**
     * Get families
     *
     * @return array $families
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Add external posts
     *
     * @param \Asbo\WhosWhoBundle\Entity\ExternalPost $externalPost
     */
    public function addExternalPost(ExternalPost $externalPost)
    {
        $externalPost->setFra($this);

        $this->externalPosts->add($externalPost);

        return $this;
    }

    /**
     * Remove an external post
     *
     * @param \Asbo\WhosWhoBundle\Entity\ExternPost $externalPost
     */
    public function removeExternalPost(ExternalPost $externalPost)
    {
        $this->externalPosts->removeElement($externalPost);

        return $this;
    }

    /**
     * Get external posts
     *
     * @return array $externalPosts
     */
    public function getExternalPosts()
    {
        return $this->externalPosts;
    }

    /**
     * Add an address
     *
     * @param \Asbo\WhosWhoBundle\Entity\Address $address
     */
    public function addAddress(Address $address)
    {
        $address->setFra($this);

        $this->addresses->add($address);

        if (null === $this->getPrincipalAddress()) {
            $this->setPrincipalAddress($address);
        }

        return $this;
    }

    /**
     * Get addresses
     *
     * @return array $addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Remove an address
     *
     * @param \Asbo\WhosWhoBundle\Entity\Address $address
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * Set the principal address
     *
     * @param \Asbo\WhosWhoBundle\Entity\Address $address
     */
    public function setPrincipalAddress(Address $address = null)
    {
        $this->principalAddress = $address;

        return $this;
    }

    /**
     * Get the principal address
     *
     * @return \Asbo\WhosWhoBundle\Entity\Address
     */
    public function getPrincipalAddress()
    {
        return $this->principalAddress;
    }

    /**
     * Add a phone
     *
     * @param \Asbo\WhosWhoBundle\Entity\Phone $phone
     */
    public function addPhone(Phone $phone)
    {
        $phone->setFra($this);
        $this->phones[] = $phone;

        if (null === $this->getPrincipalPhone()) {
            $this->setPrincipalPhone($phone);
        }

        return $this;
    }

    /**
     * Remove a phone number
     *
     * @param \Asbo\WhosWhoBundle\Entity\Phone $phone
     */
    public function removePhone(Phone $phone)
    {
        $this->phones->removeElement($phone);

        return $this;
    }

    /**
     * Get phones
     *
     * @return array $phones
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set the principal phone 
     *
     * @param \Asbo\WhosWhoBundle\Entity\Phone $phone
     */
    public function setPrincipalPhone(Phone $phone = null)
    {
        $this->principalPhone = $phone;

        return $this;
    }

    /**
     * Get the principal phone 
     *
     * @return \Asbo\WhosWhoBundle\Entity\Phone
     */
    public function getPrincipalPhone()
    {
        return $this->principalPhone;
    }

    /**
     * Set settings
     *
     * @param  array $settings
     * @return array
     */
    public function setSettings($settings)
    {
        $this->settings = array_replace($this->settings, $settings);

        return $this;
    }

    /**
     * Get settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Get setting by key
     *
     * @return string
     * @throws InvalidArgumentException If the settings doesn't exist
     */
    public function getSetting($key, $default = null)
    {
        return array_key_exists($key, $this->settings) ? $this->settings[$key] : $default;
    }

    /**
     * Return if the settings exist
     *
     * @param string $key The key
     *
     * @return boolean
     */
    public function hasSetting($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Get Type List
     *
     * @return array
     */
    public static function getTypesList()
    {
        return array(
            self::TYPE_IMPETRANT     => 'Membre Impétrant',
            self::TYPE_IN_SPE        => 'Membre In Spé',
            self::TYPE_HONORIS_CAUSA => 'Membre Honoris Causa',
            self::TYPE_CHEVALIER     => 'Chevalier',
        );
    }

    /**
     * Get Type Code
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        $type = self::getTypesList();

        return isset($type[$this->getType()]) ? $type[$this->getType()] : null;
    }

    /**
     * Get Status List
     *
     * @return array
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_TYRO             => 'Tyro',
            self::STATUS_CAPPELANUS       => 'Cappelanus',
            self::STATUS_CHEVALIER        => 'Chevalier',
            self::STATUS_CANDIDATUS       => 'Candidatus',
            self::STATUS_XHANTIPPE        => 'Xhantippe',
            self::STATUS_SODALES          => 'Sodales',
            self::STATUS_VETERANUS        => 'Veteranus',
            self::STATUS_IN_SPE           => 'Membre In Spé',
            self::STATUS_VEXILLARIUS      => 'Vexillarius',
        );

    }

    /**
     * Get Status Code
     *
     * @return string|null
     */
    public function getStatusCode()
    {
        $status = self::getStatusList();

        return isset($status[$this->getStatus()]) ? $status[$this->getStatus()] : null;
    }

    /**
     * Count total denier
     *
     * @return integer
     */
    public function countTotalDenier()
    {
        // Nombre d'année depuis que le fra est à l'ASBO
        $total = AnnoManipulator::getCurrentAnno() - $this->getAnno() + 1;

        // Rajout des deniers en fonction des posts occupés
        foreach ($this->getFraHasPosts() as $post) {
            $total += $post->getPost()->getDenier();
        }

        return $total;
    }

    /**
     * Return if the correspondence between type and status is ok
     *
     * @return boolean
     * @Assert\True(message = "Le type et le status du Fra ne sont pas compatible")
     */
    public function isValidCorrespondence()
    {
        $type   = $this->getType();
        $status = $this->getStatus();
        $matrix = self::getCorrespondenceMatrix();

        if (isset($matrix[$type][$status]) && true == $matrix[$type][$status]) {
            return true;
        }

        return false;
    }

    /**
     * Correspondence matrix
     *
     * @return string
     */
    public static function getCorrespondenceMatrix()
    {
        return self::$correspondenceMatrix;
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        $nickname = $this->getNickname();

        return $this->firstname. (!empty($nickname) ? ' ('.$nickname.') ': ' ').$this->lastname;
    }
}
