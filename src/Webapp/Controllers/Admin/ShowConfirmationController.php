<?php

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;

class ShowConfirmationController implements Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $name = implode( ' ', [$request->getPostParam('userName'), $request->getPostParam('userLastName')]);
        $email = $request->getPostParam('userEmail');

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/newUserConfirmation.php', [
            'name' => $name,
            'email' => $email
        ]);
    }
}