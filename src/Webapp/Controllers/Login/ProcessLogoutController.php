<?php

namespace Webapp\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Session\SessionManager;

class ProcessLogoutController implements Controller
{
    public function handle(Request $request): Response
    {
        $session = container(SessionManager::class);
        $session->logOut();
        return redirect('/login');
    }
}