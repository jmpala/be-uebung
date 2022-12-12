<?php

namespace Framework\Middleware\Authentication;

use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;

class AuthenticationMidd extends AbstractHandler
{
    protected function process(Request $request): Request
    {

        return $request;
    }
}