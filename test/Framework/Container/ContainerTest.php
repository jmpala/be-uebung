<?php

namespace Framework\Container;

use Framework\Router\Router;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function tearDown(): void
    {
        Container::destroy();
    }

    public function testContainerExist(): void
    {
        $container = Container::getInstance();
        $this->assertNotNull($container);
    }

    public function testFactoryIsRegistered(): void
    {
        $container = Container::getInstance();
        $factoryName = 'router';
        $container->register($factoryName, Router::class);
        $this->assertTrue($container->hasFactory($factoryName), 'instance is not registered into the container');
    }

    public function testObtainRegisteredInstance(): void
    {
        $container = Container::getInstance();
        $factoryName = 'router';
        $registeredInstance = $factoryName;
        $container->register($factoryName, Router::class);

        $instance = $container->fetch($registeredInstance);

        $this->assertNotNull($instance, 'the instance was not created');
    }

    public function testErrorObtainingUnregisteredInstance(): void
    {
        $container = Container::getInstance();
        $unknown = 'router';

        $this->expectException(\InvalidArgumentException::class);
        $instance = $container->fetch($unknown);
    }
}
