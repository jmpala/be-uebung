<?php

declare(strict_types=1);

namespace Webapp\Controllers\Login;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Session\SessionManager;

class ShowLoginPageController implements \Framework\Contracts\Controller
{
    private SessionManager $sessionManager;
    private Response $response;

    public function __construct()
    {
        $this->sessionManager = container(SessionManager::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(200);

        if ($this->sessionManager->isLoggedIn()) {
            return redirect('/overview');
        }

        return handleView('login/login.simplephp.php');
    }
}