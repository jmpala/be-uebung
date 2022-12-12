<?php

namespace Unit\Framework\Http;

use Framework\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testResponseExist(): void
    {
        $this->assertNotNull(new Response());
    }
}
