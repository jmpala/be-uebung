<?php

namespace RESTapi\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\LoginService;

class ProcessLoginRESTController implements Controller
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
        $user= $request->getPostParam('email');
        $password = $request->getPostParam('password');
        $isLogged = $this->loginService->login($user, $password);

        $this->response->addHeader('Content-Type', 'application/json');

        if ($isLogged) {
            $token = $_COOKIE['jwttoken']; // TODO: refactor in config file

            $this->response->statusCode(StatusCode::OK);
            return $this->response->content(json_encode(['token' => $token]));
        }

        $this->response->statusCode(StatusCode::UNAUTHORIZED);
        return $this->response->content(json_encode(['message' => StatusCode::MESSAGES[StatusCode::UNAUTHORIZED]]));
    }
}