<?php

namespace Framework\Contracts;

use Framework\Http\Request;

interface Controller
{
    // TODO: return view
    public function handle(Request $request);
}