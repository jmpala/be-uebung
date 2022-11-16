<?php

namespace Container;

use Framework\Container\Container;
use Framework\Router\Router;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainerExist(): void
    {
        $container = new Container();
        $this->assertNotNull($container);
    }

    public function testFactoryIsRegistered(): void
    {
        $container = new Container();
        $factoryName = 'router';
        $container->register($factoryName, Router::class);
        $this->assertTrue($container->hasFactory($factoryName), 'instance is not registered into the container');
    }

    public function testObtainRegisteredInstance(): void
    {
        $container = new Container();
        $factoryName = 'router';
        $registeredInstance = $factoryName;
        $container->register($factoryName, Router::class);

        $instance = $container->fetch($registeredInstance);

        $this->assertNotNull($instance, 'the instance was not created');
    }

    public function testErrorObtainingUnregisteredInstance(): void
    {
        $container = new Container();
        $unknown = 'router';

        $this->expectException(\InvalidArgumentException::class);
        $instance = $container->fetch($unknown);
    }
}
