<?php

declare(strict_types=1);

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