<?php

declare(strict_types=1);

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;

class SampleProcessController implements Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(StatusCode::OK);
        return redirect('/');
    }
}