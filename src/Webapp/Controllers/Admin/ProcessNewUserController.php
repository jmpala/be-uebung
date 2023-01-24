<?php

declare(strict_types=1);

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ProcessNewUserController implements Controller
{
    private UserService $userService;
    private Response $response;

    public function __construct()
    {
        $this->userService = container(UserService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $name = $request->getPostParam('userName');
        $email= $request->getPostParam('userEmail');
        $roleID = $request->getPostParam('roleID');

        $newUser = $this->userService->createUser([
            'name' => $name,
            'email' => $email,
        ], $roleID);

        $roleName = $this->userService->getRoleName($roleID);

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/newUserDetails.php', [
            'id' => $newUser,
            'name' => $name,
            'email' => $email,
            'roleName' => $roleName,
        ]);
    }
}