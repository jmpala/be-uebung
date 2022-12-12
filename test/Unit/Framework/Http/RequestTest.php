<?php

namespace Unit\Framework\Http;

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
        $request->addURIParam($key, '1');

        $this->assertTrue($request->existURIParam($key), 'the param does not exist');
    }

    public function retrieveExistingURIParam(): void
    {
        $request = new Request();
        $key = 'id';
        $value = '1';
        $request->addURIParam($key, $value);

        $this->assertEquals($value, $request->getURIParam($key));
    }

    public function testExistPostParam(): void
    {
        $request = new Request();
        $key = 'username';
        $request->addPostParam($key, 'randomuser');

        $this->assertTrue($request->existPostParam($key), 'the param does not exist');
    }
}