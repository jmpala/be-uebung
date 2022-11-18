<?php

namespace unit\Framework\Http;

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
        $request = new Request();
        $request->method($method);
        $request->uri($uri);
        $this->assertEquals($method, $request->method());
        $this->assertEquals($uri, $request->uri());
    }

    public function testExistUriParam(): void
    {
        $request = new Request();
        $key = 'id';
        $request->addParam($key, '1');

        $this->assertTrue($request->existParam($key), 'the param does not exist');
    }

    public function retrieveExistingParam(): void
    {
        $request = new Request();
        $key = 'id';
        $value = '1';
        $request->addParam($key, $value);

        $this->assertEquals($value, $request->getParam($key));
    }
}