<?php

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;

class SampleProcessController implements Controller
{

    public function handle(Request $request): Response
    {
        return redirect('/');
    }
}