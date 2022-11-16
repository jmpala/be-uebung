<?php

namespace Framework\Contracts;

use Framework\Http\Request;
use Framework\Http\Response;

interface Runnable
{
    public function run(Request $request, array $params = []): Response;
}