<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Routing;

use Asbo\WhosWhoBundle\Routing\UrlGenerator as UrlGeneratorTested;
use Asbo\WhosWhoBundle\Tests\Units;

class UrlGenerator extends Units\Test
{
    protected $generatorMock;

    protected $instance;

    protected $url;

    public function beforeTestMethod($method)
    {
        $this->generatorMock = new \Mock\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
        $this->instance      = new UrlGeneratorTested($this->generatorMock);

        $this->calling($this->generatorMock)->generate = ($this->url = uniqid());
    }

    public function testGenerate()
    {
        $route  = uniqid();
        $params = [uniqid()];

        $this->string($this->instance->generate($route))->isEqualTo($this->url);
        $this->string($this->instance->generate($route, []))->isEqualTo($this->url);
        $this->string($this->instance->generate($route, $params))->isEqualTo($this->url);
        $this->string($this->instance->generate($route, $params, true))->isEqualTo($this->url);
        $this->string($this->instance->generate($route, [], true))->isEqualTo($this->url);

        $this->mock($this->generatorMock)
                ->call('generate')
                    ->withArguments($route, [], false)
                    ->twice()
                    ->withArguments($route, $params, false)
                    ->once()
                    ->withArguments($route, $params, true)
                    ->once()
                    ->withArguments($route, [], true)
                    ->once();

    }

    public function testFra()
    {
        $fraMock = new \Mock\Asbo\WhosWhoBundle\Entity\Fra();
        $this->calling($fraMock)->getSlug = ($slug = uniqid());

        $this->string($this->instance->fra($fraMock))->isEqualTo($this->url);
        $this->string($this->instance->fra($fraMock, true))->isEqualTo($this->url);

        $this->mock($fraMock)
                ->call('getSlug')
                    ->twice();

        $this->mock($this->generatorMock)
                ->call('generate')
                    ->withIdenticalArguments('asbo_whoswho_fra_show', ['slug' => $slug], false)
                    ->once()
                    ->withIdenticalArguments('asbo_whoswho_fra_show', ['slug' => $slug], true)
                    ->once();
    }
}
