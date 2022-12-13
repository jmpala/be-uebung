<?php

namespace Webapp\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\DAOs\RoleDAO;
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
        $sessionManager->add(SessionManager::USER_ID, $user['id']);

        $role = RoleDAO::selectById($user['role_id']);
        $sessionManager->add(SessionManager::USER_ROLE, $role['code']);

        return redirect('/overview');
    }
}