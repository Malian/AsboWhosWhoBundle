<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Entity;

use Asbo\WhosWhoBundle\Entity\Fra as BaseFra;
use Asbo\WhosWhoBundle\Tests\Units;

class Fra extends Units\Test
{

    public function testCreate()
    {
        $fra = new BaseFra;

        $this->variable($fra->getFirstname())->isNull();
        $this->variable($fra->getLastname())->isNull();
        $this->variable($fra->getNickname())->isNull();
        $this->variable($fra->getBornAt())->isNull();
        $this->variable($fra->getDiedAt())->isNull();
        $this->variable($fra->getBornIn())->isNull();
        $this->variable($fra->getDiedIn())->isNull();
        $this->variable($fra->getSlug())->isNull();

        $instance = '\Doctrine\Common\Collections\ArrayCollection';
        $this->object($fra->getEmails())->isInstanceOf($instance);
        $this->object($fra->getJobs())->isInstanceOf($instance);
        $this->object($fra->getDiplomas())->isInstanceOf($instance);
        $this->object($fra->getFamilies())->isInstanceOf($instance);
        $this->object($fra->getAddresses())->isInstanceOf($instance);
        $this->object($fra->getPhones())->isInstanceOf($instance);
        $this->object($fra->getExternalPosts())->isInstanceOf($instance);
        $this->object($fra->getFraHasPosts())->isInstanceOf($instance);
        $this->object($fra->getFraHasImages())->isInstanceOf($instance);
        $this->object($fra->getFraHasUsers())->isInstanceOf($instance);

        $this->sizeOf($fra->getEmails())->isZero();
        $this->sizeOf($fra->getJobs())->isZero();
        $this->sizeOf($fra->getDiplomas())->isZero();
        $this->sizeOf($fra->getFamilies())->isZero();
        $this->sizeOf($fra->getAddresses())->isZero();
        $this->sizeOf($fra->getPhones())->isZero();
        $this->sizeOf($fra->getExternalPosts())->isZero();
        $this->sizeOf($fra->getFraHasPosts())->isZero();
        $this->sizeOf($fra->getFraHasUsers())->isZero();
        $this->sizeOf($fra->getFraHasImages())->isZero();

        $this->integer($fra->getGender())->isZero();
        $this->integer($fra->getAnno())->isGreaterThanOrEqualTo(0);
        $this->integer($fra->getType())->isEqualTo(BaseFra::TYPE_IMPETRANT);
        $this->integer($fra->getStatus())->isEqualTo(BaseFra::STATUS_TYRO);

        $this->boolean($fra->isValidCorrespondence())->isTrue();
        $this->boolean($fra->isPontif())->isFalse();

        $this->array($fra->getSettings())->isNotEmpty();
    }

    public function testSetttersAndGetters()
    {
        $fra = new BaseFra;

        $id        = $this->faker->randomDigitNotNull();
        $firstname = $this->faker->firstname();
        $lastname  = $this->faker->lastname();
        $nickname  = $this->faker->firstname();
        $gender    = $this->faker->randomNumber(0, 1);
        $bornAt    = $this->faker->dateTimeBetween('-30 years', 'now');
        $diedAt    = $this->faker->dateTimeBetween($bornAt, 'now');
        $bornIn    = $this->faker->state();
        $diedIn    = $this->faker->state();
        $pontif    = $this->faker->boolean(50);
        $slug      = $this->faker->word();
        $type      = array_rand(BaseFra::getTypesList());
        $status    = array_rand(BaseFra::getStatusList());

        $this->object($fra->setId($id))->isIdenticalTo($fra);
        $this->object($fra->setFirstname($firstname))->isIdenticalTo($fra);
        $this->object($fra->setLastname($lastname))->isIdenticalTo($fra);
        $this->object($fra->setNickname($nickname))->isIdenticalTo($fra);
        $this->object($fra->setGender($gender))->isIdenticalTo($fra);
        $this->object($fra->setBornAt($bornAt))->isIdenticalTo($fra);
        $this->object($fra->setDiedAt($diedAt))->isIdenticalTo($fra);
        $this->object($fra->setDiedIn($diedIn))->isIdenticalTo($fra);
        $this->object($fra->setBornIn($bornIn))->isIdenticalTo($fra);
        $this->object($fra->setPontif($pontif))->isIdenticalTo($fra);
        $this->object($fra->setSlug($slug))->isIdenticalTo($fra);
        $this->object($fra->setType($type))->isIdenticalTo($fra);
        $this->object($fra->setStatus($status))->isIdenticalTo($fra);
        $this->object($fra->setAnno($anno = 24))->isIdenticalTo($fra);

        $this->integer($fra->getId())->isEqualTo($id);
        $this->integer($fra->getGender())->isEqualTo($gender);
        $this->integer($fra->getType())->isEqualTo($type);
        $this->integer($fra->getStatus())->isEqualTo($status);
        $this->integer($fra->getAnno())->isEqualTo($anno);

        $this->string($fra->getFirstname())->isEqualTo($firstname);
        $this->string($fra->getLastname())->isEqualTo($lastname);
        $this->string($fra->getNickname())->isEqualTo($nickname);
        $this->string($fra->getSlug())->isEqualTo($slug);
        $this->string($fra->getBornIn())->isEqualTo($bornIn);
        $this->string($fra->getDiedIn())->isEqualTo($diedIn);

        $this->datetime($fra->getBornAt())->isEqualTo($bornAt);
        $this->datetime($fra->getDiedAt())->isEqualTo($diedAt);

        $this->boolean($fra->isPontif())->isEqualTo($pontif);
    }

    public function testToString()
    {
        $fra       = new BaseFra;

        $this->castToString($fra)
                ->isEqualTo(' ');

        $firstname = $this->faker->firstname;
        $lastname  = $this->faker->lastname;
        $nickname  = $this->faker->firstname;

        $fra->setFirstname($firstname)
            ->setLastname($lastname);

        $this->castToString($fra)->isEqualTo($firstname . ' ' . $lastname);

        $fra->setNickName($nickname);
        $this->castToString($fra)->isEqualTo($firstname . ' (' . $nickname . ') ' . $lastname);

        $fra->setNickname('');
        $this->castToString($fra)->isEqualTo($firstname . ' ' . $lastname);
    }

    public function testValidCorrespondenceMatrix()
    {
        $matrix = BaseFra::getCorrespondenceMatrix();

        $this->array($matrix)->hasSize(4);

        foreach ($matrix as $type => $status) {

            $this->integer($type);
            $this->array($status)->hasSize(9);

            foreach ($status as $val) {
                $this->integer($val);
            }
        }
    }

    /**
     * @dataProvider matrixProvider
     */
    public function testIsValidCorrespondenceBetweenTypeAndStatus($a, $b, $c)
    {
        $fra = new BaseFra;

        $fra->setType($a);
        $fra->setStatus($b);

        $this->boolean($fra->isValidCorrespondence())->isEqualTo((boolean) $c);
    }

    public function matrixProvider()
    {
        return array(

            // Impétrant
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_TYRO, true),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_CANDIDATUS, true),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_CHEVALIER, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_XHANTIPPE, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_VETERANUS, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_IN_SPE, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_CAPPELANUS, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_VEXILLARIUS, false),
            array(BaseFra::TYPE_IMPETRANT, BaseFra::STATUS_SODALES, false),

            // In Spé
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_TYRO, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_CANDIDATUS, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_CHEVALIER, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_XHANTIPPE, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_VETERANUS, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_IN_SPE, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_CAPPELANUS, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_VEXILLARIUS, true),
            array(BaseFra::TYPE_IN_SPE, BaseFra::STATUS_SODALES, true),

            // Honoris Causa
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_TYRO, false),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_CANDIDATUS, false),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_CHEVALIER, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_XHANTIPPE, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_VETERANUS, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_IN_SPE, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_CAPPELANUS, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_VEXILLARIUS, true),
            array(BaseFra::TYPE_HONORIS_CAUSA, BaseFra::STATUS_SODALES, true),

            // Chevalier
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_TYRO, false),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_CANDIDATUS, false),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_CHEVALIER, true),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_XHANTIPPE, true),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_VETERANUS, true),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_IN_SPE, false),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_CAPPELANUS, true),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_VEXILLARIUS, true),
            array(BaseFra::TYPE_CHEVALIER, BaseFra::STATUS_SODALES, true),
            );
    }

    public function testTypeList()
    {
        $this->array($types = BaseFra::getTypesList())->hasSize(4);

        foreach ($types as $key => $val) {

            $this->integer($key);
            $this->string($val);

            $fra = (new BaseFra)->setType($key);
            $this->integer($fra->getType())->isEqualTo($key);
            $this->string($fra->getTypeCode())->isEqualTo($val);
        }
    }

    public function testStatusList()
    {
        $this->array($status = BaseFra::getStatusList())->hasSize(9);

        foreach ($status as $key => $val) {

            $this->integer($key);
            $this->string($val);

            $fra = (new BaseFra)->setstatus($key);
            $this->integer($fra->getstatus())->isEqualTo($key);
            $this->string($fra->getstatusCode())->isEqualTo($val);

        }
    }

    public function testGetSettingException()
    {
        $fra = new BaseFra;

        $this->variable($fra->getSetting('unknow'))->isNull();
    }

    public function testDefaultSettings()
    {
        $fra = new BaseFra;

        foreach ($fra->getSettings() as $key => $value) {
            $this->dump($key);
            $this->boolean($fra->getSetting($key))->isTrue();
        }

        $settings = array(
            'whoswho'               => $this->faker->boolean(50),
            'pereat'                => $this->faker->boolean(50),
            'convoc_externe'        => $this->faker->boolean(50),
            'convoc_banquet'        => $this->faker->boolean(50),
            'convoc_we'             => $this->faker->boolean(50),
            'convoc_ephemerides_q1' => $this->faker->boolean(50),
            'convoc_ephemerides_q2' => $this->faker->boolean(50)
        );

        $this->object($fra->setSettings($settings))->isIdenticalTo($fra);
        $this->array($fra->getSettings())->isEqualTo($settings);

        foreach ($fra->getSettings() as $key => $value) {
            $this->boolean($fra->hasSetting($key))->isTrue();
            $this->boolean($fra->getSetting($key))->isEqualTo($value);
            $this->boolean($fra->getSetting($key))->isEqualTo($settings[$key]);
        }
    }

    public function testSetOthersSettings()
    {
        $fra          = new BaseFra;
        $setting      = 'emailNotification';

        $this->object($fra->setSettings(array($setting => $bool = $this->faker->boolean(50))))->isIdenticalTo($fra);
        $this->boolean($fra->hasSetting($setting))->isTrue();
        $this->boolean($fra->getSetting($setting))->isEqualTo($bool);
    }

    public function testCountTotalDenier()
    {
        $fra         = new BaseFra;
        $currentAnno = $fra->getAnno();
        $anno        = $this->faker->randomNumber(0, $currentAnno);
        $fra->setAnno($anno);

        $this->integer($fra->countTotalDenier())->isEqualTo(($currentAnno - $anno)+1);

        $post1 = $this->createPostMock(1, $dernier1 = $this->faker->randomNumber(1, 4));
        $post2 = $this->createPostMock(2, $dernier2 = $this->faker->randomNumber(1, 4));
        $post3 = $this->createPostMock(3, $dernier3 = $this->faker->randomNumber(1, 4));

        $fraHasPost1 = $this->createFraHasPostMock(1, $post1);
        $fraHasPost2 = $this->createFraHasPostMock(2, $post2);
        $fraHasPost3 = $this->createFraHasPostMock(3, $post3);

        $fra->addFraHasPost($fraHasPost1);
        $fra->addFraHasPost($fraHasPost2);
        $fra->addFraHasPost($fraHasPost3);

        $this->integer($fra->countTotalDenier())->isEqualTo(($currentAnno - $anno)+1+$dernier1+$dernier2+$dernier3);

    }

    /**
     * @dataProvider getSimpleTestData
     */
    public function testAddGetEntity($property, $plural)
    {
        if (null === $plural) {
            $plural = $property;
        }

        $fra            = new BaseFra;
        $mockClass      = '\Mock\Asbo\WhosWhoBundle\Entity\\'.$property;
        $mock           = new $mockClass;
        $addFunction    = 'add'.$property;
        $getFunction    = 'get'.$plural.'s';
        $removeFunction = 'remove'.$property;

        $this->object($fra->$getFunction())
                ->isInstanceOf('Doctrine\Common\Collections\ArrayCollection')
                ->hasSize(0)
             ->object($fra->$addFunction($mock))
                ->isIdenticalTo($fra)
             ->sizeOf($fra->$getFunction())
                ->isEqualTo(1)
             ->object($fra->$getFunction()->first())
                ->isIdenticalTo($mock)
             ->object($fra->$removeFunction($mock))
                ->isIdenticalTo($fra)
             ->object($fra->$getFunction())
               ->hasSize(0);
        ;
    }

    protected function getSimpleTestData()
    {
        $array = [
            ['Phone'],
            ['Email'],
            ['FraHasUser'],
            ['Job'],
            ['ExternalPost'],
            ['Email'],
            ['FraHasPost'],
            ['Diploma'],
        //    ['FraHasImage', null],
            ['Family', 'Familie'],
            ['Address', 'Addresse'],
        ];

        return array_map('array_pad', $array, array_fill(0, count($array), 2), array_fill(0, count($array), null));
    }

    public function testAddAdressWithoutPrincipalAddress()
    {
        $this->if($fra = new BaseFra())
             ->then
                ->sizeOf($fra->getAddresses())
                    ->isZero()
                ->variable($fra->getPrincipalAddress())
                    ->isNull()
             ->if($mock = new \Mock\Asbo\WhosWhoBundle\Entity\Address())
             ->and($fra->addAddress($mock))
             ->then
                ->sizeOf($fra->getAddresses())
                    ->isEqualTo(1)
                ->object($fra->getPrincipalAddress())
                    ->isIdenticalTo($mock)
            ->if($mock2 = new \Mock\Asbo\WhosWhoBundle\Entity\Address())
            ->and($fra->addAddress($mock2))
            ->then
                ->sizeof($fra->getAddresses())
                    ->isEqualTo(2)
                ->object($fra->getPrincipalAddress())
                    ->isIdenticalTo($mock)
                    ->isNotIdenticalTo($mock2)
            ->if($fra->setPrincipalAddress(null))
            ->then
                ->sizeOf($fra->getAddresses())
                    ->isEqualTo(2)
                ->variable($fra->getPrincipalAddress())
                    ->isNull();
    }

    public function testPrincipalAddress()
    {
        $fra  = new BaseFra();
        $mock = new \Mock\Asbo\WhosWhoBundle\Entity\Address();

        $this->variable($fra->getPrincipalAddress())
                ->isNull();

        $this->if($fra = new BaseFra())
             ->then
                ->variable($fra->getPrincipalAddress())
                    ->isNull()
             ->if($address = new \Mock\Asbo\WhosWhoBundle\Entity\Address())
             ->then
                ->object($fra->setPrincipalAddress($address))
                    ->isIdenticalTo($fra)
                ->object($fra->getPrincipalAddress())
                    ->isIdenticalTo($address)
            ->if($fra->setPrincipalAddress(null))
            ->then
                ->variable($fra->getPrincipalAddress())
                    ->isNull();
    }

    public function createFraHasPostMock($id, $post = null)
    {
        $fraHasPost = new \Mock\Asbo\WhosWhoBundle\Entity\FraHasPost();
        $this->calling($fraHasPost)->getId   = $id;
        $this->calling($fraHasPost)->getPost = $post;

        return $fraHasPost;
    }

    protected function createPostMock($id, $denier = null)
    {
        $post                            = new \Mock\Asbo\WhosWhoBundle\Entity\Post();
        $this->calling($post)->getId     = $id;
        $this->calling($post)->getDenier = $denier;

        return $post;
    }
}
