<?php

declare(strict_types=1);

namespace Webapp\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Services\LoginService;

class ProcessLoginController implements Controller
{
    private LoginService $loginService;
    private Response $response;

    public function __construct()
    {
        $this->loginService = container(LoginService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(200);

        $email = $request->getPostParam('email');
        $password = $request->getPostParam('password');
        $isLogged = $this->loginService->login($email, $password);

        if (!$isLogged) {
            return redirect('/login');
        }

        return redirect('/overview');
    }
}