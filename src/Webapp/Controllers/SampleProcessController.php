<?php

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;

class SampleProcessController implements Controller
{

    public function handle(Request $request)
    {
        return "Hello World Processing!";
    }
}