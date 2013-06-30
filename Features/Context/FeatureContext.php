<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Features\Context;

use Behat\Behat\Context\Step;
use Behat\Behat\Context\Step\Then;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class FeatureContext extends MinkContext
{
    use \Behat\Symfony2Extension\Context\KernelDictionary;

    /**
     * @var array $parameters
     */
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    protected function logLastResponse()
    {
        file_put_contents('behat.out.html', $this->getSession()->getPage()->getContent());
    }

    /**
     * @When /^(?:|I )visit (?:|the )hello world page$/
     */
    public function iVisitTheHelloWorldPage()
    {
        $url = empty($this->name) ? '/hello' : sprintf('/hello/%s', $this->name);

        return new Then(sprintf('I go to "%s"', $url));
    }

    /**
     * @When /^I visit the whoswho main page$/
     */
    public function iVisitTheWhoswhoMainPage()
    {
        $url = 'list';

        return new Then(sprintf('I go to "%s"', $url));
    }

    /**
     * @When /^I am login as an user$/
     */
    public function iAmLoginAsAnUser()
    {
        return array(
            new Step\Given('I am on "/demo/secured/login"'),
            new Step\When('I fill in "_username" with "user"'),
            new Step\When('I fill in "_password" with "userpass"'),
            new Step\When('I press "Login"')
        );
    }

    /**
     * @When /^I visite the fra "([^"]*)"$/
     */
    public function iVisiteTheFra($fra)
    {
        return array(
            new Then(sprintf('I go to "/fra/%s"', $fra))
        );
    }

    /**
     * @Given /^Database is set$/
     */
    public function databaseIsSet()
    {
        $em       = $this->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }

    /**
     * @Given /^There is a fra "([^"]*)" "([^"]*)" with slug "([^"]*)"$/
     */
    public function thereIsAFra($firstname, $lastname, $slug)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $entity = new \Asbo\WhosWhoBundle\Entity\Fra();
        $entity->setFirstname($firstname);
        $entity->setLastname($lastname);
        $entity->setSlug($slug);

        $em->persist($entity);
        $em->flush();
    }
}
