<?php

namespace Webapp\Controllers\Login;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Session\SessionManager;

class ShowLoginPageController implements \Framework\Contracts\Controller
{
    public function handle(Request $request): Response
    {
        $sessionManager = container(SessionManager::class);

        if ($sessionManager->isLoggedIn()) {
            return redirect('/overview');
        }

        return handleView('login/login.simplephp.php');
    }
}