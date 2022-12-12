<?php

namespace Unit\Framework\Middleware;

use Framework\Contracts\RequestHandler;
use Framework\Http\Request;
use Framework\Middleware\Middleware;
use PHPUnit\Framework\TestCase;
use Unit\Framework\Middleware\TestHandlers\FirstHandler;
use Unit\Framework\Middleware\TestHandlers\SecondHandler;
use Unit\Framework\Middleware\TestHandlers\ThirdHandler;

class MiddlewareTest extends TestCase
{
    public function test_middleware_exist(): void
    {
        $middleware = new Middleware();
        $this->assertNotNull($middleware);
    }

    public function test_register_handlers(): void
    {
        $middleware = new Middleware();
        $addedHandlers = 3;
        $reqHandler1 = $this->createMock(RequestHandler::class);
        $reqHandler2 = $this->createMock(RequestHandler::class);
        $reqHandler3 = $this->createMock(RequestHandler::class);

        $middleware
            ->pipe($reqHandler1)
            ->pipe($reqHandler2)
            ->pipe($reqHandler3);

        self::assertEquals($addedHandlers, $middleware->handlerCount());
    }

    public function test_execute_handlers_in_order(): void
    {
        $middleware = new Middleware();
        $request = new Request();
        $reqHandler1 = new FirstHandler();
        $reqHandler2 = new SecondHandler();
        $reqHandler3 = new ThirdHandler();
        $expectedString = '1-2-3';

        $middleware
            ->pipe($reqHandler1)
            ->pipe($reqHandler2)
            ->pipe($reqHandler3);

        $req = $middleware->run($request);

        self::assertEquals($expectedString, $req->getPostParam('testing'));
    }
}