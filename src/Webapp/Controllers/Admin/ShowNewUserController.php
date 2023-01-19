<?php

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;

class ShowNewUserController implements Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/newUser.php', []);
    }
}