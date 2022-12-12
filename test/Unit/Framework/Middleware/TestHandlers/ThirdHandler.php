<?php

namespace Unit\Framework\Middleware\TestHandlers;

use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;

class ThirdHandler extends AbstractHandler
{
    protected function process(Request $request): Request
    {
        $request->addPostParam('testing', $request->getPostParam('testing') . '-3');
        return $request;
    }
}
