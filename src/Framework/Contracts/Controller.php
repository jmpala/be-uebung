<?php

declare(strict_types=1);

namespace Framework\Contracts;

use Framework\Http\Request;
use Framework\Http\Response;

interface Controller
{
    // TODO: return view
    public function handle(Request $request): Response;
}