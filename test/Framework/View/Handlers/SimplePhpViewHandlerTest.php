<?php

namespace Framework\View\Handlers;

use PHPUnit\Framework\TestCase;

class SimplePhpViewHandlerTest extends TestCase
{
    public function testHandlerExist(): void
    {
        self::assertNotNull(new SimplePhpViewHandler());
    }

    public function testCanHandleSimplePhp(): void
    {
        $handler = new SimplePhpViewHandler();
        self::assertTrue($handler->canHandle('samplefilename.simplephp.php'));
    }
}
