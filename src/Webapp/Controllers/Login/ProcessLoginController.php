<?php

namespace Webapp\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\DAOs\UserDAO;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Session\SessionManager;

class ProcessLoginController implements Controller
{

    public function handle(Request $request): Response
    {
        $email = $request->getPostParam('email');
        $user = UserDAO::selectByEmail($email);

        if (!$user || !password_verify($request->getPostParam('password'), $user['password'])) {
            return redirect('/login');
        }

        $sessionManager = container(SessionManager::class);
        $sessionManager->logIn();
        $sessionManager->add($user['id'], $user);

        return redirect('/overview');
    }
}