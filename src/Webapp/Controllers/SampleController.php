<?php

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;

class SampleController implements Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        return redirect('/overview');
    }
}