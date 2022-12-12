<?php

namespace Unit\Framework\Middleware\TestHandlers;

use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;

class SecondHandler extends AbstractHandler
{
    protected function process(Request $request): Request
    {
        $request->addPostParam('testing', $request->getPostParam('testing') . '-2');
        return $request;
    }
}