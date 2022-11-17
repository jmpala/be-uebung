<?php

namespace Webapp\Controllers\Login;

use Framework\Http\Request;
use Framework\Http\Response;

class ShowLoginPageController implements \Framework\Contracts\Controller
{
    public function handle(Request $request): Response
    {
        return handleView('login/login.simplephp.php');
    }
}