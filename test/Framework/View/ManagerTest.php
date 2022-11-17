<?php

namespace Framework\View;

use Framework\Contracts\ViewHandler;
use Framework\Contracts\ViewHandlerProvider;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testManagerExist(): void
    {
        self::assertNotNull(new Manager());
    }

    public function testRegisterViewEngines(): void
    {
        $manager = new Manager();
        $handler = $this->createMock(ViewHandler::class);
        $handlerName = 'simpleHandler';
        $manager->registerHandler($handlerName, $handler);
        $this->assertTrue($manager->hasHandler($handlerName));
    }

    public function testHandleMethodInHandlerContractIsCalled(): void
    {
        $manager = new Manager();
        $handler = $this->createMock(ViewHandler::class);
        $handler
            ->expects(self::once())
            ->method('handle')
            ->willReturn('string');

        $handler
            ->method('canHandle')
            ->willReturn(true);

        $handlerName = 'simpleHandler';
        $manager->registerHandler($handlerName, $handler);

        $manager->handle($handlerName);
    }

    public function testProvideViewHandlersIsCalled(): void
    {
        $manager = new Manager();
        $provider = $this->createMock(ViewHandlerProvider::class);
        $provider->expects(self::once())
            ->method('provideViewHandlers');
        $manager->getHandlersFromProvider($provider);
    }

}
