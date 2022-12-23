<?php

namespace Unit\Framework\Http;

use Framework\Http\Response;
use Framework\Http\StatusCode;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testResponseExist(): void
    {
        $this->assertNotNull(new Response());
    }

    public function testResponseAddHeader(): void
    {
        $response = new Response();
        $response->addHeader('Content-Type', 'text/html');
        $this->assertEquals('text/html', $response->getHeader('Content-Type'));
    }

    public function testResponseRemoveHeader(): void
    {
        $response = new Response();
        $response->addHeader('Content-Type', 'text/html');
        $response->removeHeader('Content-Type');
        $this->assertFalse($response->isHeaderSet('Content-Type'));
    }

    public function testResponseHeaderIsSet(): void
    {
        $response = new Response();
        $response->addHeader('Content-Type', 'text/html');
        $this->assertTrue($response->isHeaderSet('Content-Type'));
    }

    public function testResponseSetStatusCode(): void
    {
        $response = new Response();
        $response->statusCode(200);
        $this->assertEquals(200, $response->statusCode());
    }

    public function testResponseStatusCodeMessage(): void
    {
        $response = new Response();
        $response->statusCode(StatusCode::OK);
        $this->assertEquals(StatusCode::MESSAGES[StatusCode::OK], $response->statusCodeMessage());
    }
}
