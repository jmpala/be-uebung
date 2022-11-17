<?php

namespace Framework\Http;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testResponseExist(): void
    {
        $this->assertNotNull(new Response());
    }
}
