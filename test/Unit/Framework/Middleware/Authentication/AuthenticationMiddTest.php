<?php

namespace Unit\Framework\Middleware\Authentication;

use Framework\Middleware\Authentication\AuthenticationMidd;
use PHPUnit\Framework\TestCase;

class AuthenticationMiddTest extends TestCase
{
    public function test_authentication_midd_exist(): void
    {
        $authenticationMidd = new AuthenticationMidd();
        $this->assertNotNull($authenticationMidd);
    }

}