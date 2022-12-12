<?php

namespace Framework\Contracts;

use Framework\Http\Request;

/*
 * Middleware chain of responsibility contract
 */
interface RequestHandler
{
    public function setNext(RequestHandler $handler);

    public function handle(Request $request);
}