<?php

namespace Webapp\Controllers\Login;

use Framework\Contracts\Controller;
use Framework\DAOs\UserDAO;
use Framework\Http\Request;
use Framework\Http\Response;

class ProcessLoginController implements Controller
{

    public function handle(Request $request): Response
    {
        $email = $request->getPostParam('email');
        $user = UserDAO::selectByEmail($email);

        if (!$user) {
            var_dump("User not found");
            exit();
        }

        var_dump($user);
        exit();
    }
}