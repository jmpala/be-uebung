<?php

namespace Unit\Framework\Middleware\TestHandlers;

use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;

class FirstHandler extends AbstractHandler
{
    protected function process(Request $request): Request
    {
        $request->addPostParam('testing', '1');
        return $request;
    }
}