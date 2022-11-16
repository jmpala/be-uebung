<?php

use Framework\Http\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{
    public function testRequestExist(): void
    {
        $request = new Request('GET', '/');
        $this->assertNotNull($request);
    }

    public function testIntegrityOfHttpMethodAndUri(): void
    {
        $method = 'GET';
        $uri = '/';
        $request = new Request($method, $uri);
        $this->assertEquals($method, $request->method());
        $this->assertEquals($uri, $request->uri());
    }

    public function testExistUriParam(): void
    {
        $request = new Request('GET', '/');
        $key = 'id';
        $request->addParam($key, '1');

        $this->assertTrue($request->existParam($key), 'the param does not exist');
    }
}