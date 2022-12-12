<?php

namespace Unit\Framework\Middleware;

use Framework\Middleware\AbstractHandler;
use PHPUnit\Framework\TestCase;

class AbstractHandlerTest extends TestCase
{
    public function test_abstract_handler_exist(): void
    {
        $abstractHandler = $this->createMock(AbstractHandler::class);
        $this->assertNotNull($abstractHandler);
    }
}