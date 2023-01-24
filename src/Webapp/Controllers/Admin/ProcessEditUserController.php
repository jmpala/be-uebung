<?php

declare(strict_types=1);

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ProcessEditUserController implements Controller
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
        $email = $request->getPostParam('userEmail');
        $userID = $request->getPostParam('userID');
        $roleID = $request->getPostParam('roleID');

        $updatedUser = $this->userService->updateUser([
            'id' => $userID,
            'name' => $name,
            'email' => $email,
        ], $roleID);

        $roleName = $this->userService->getRoleName($roleID);

        if (!$updatedUser) throw new \Exception('Could not update user');

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/editUserDetails.php', [
            'id' => $userID,
            'name' => $name,
            'email' => $email,
            'roleName' => $roleName,
        ]);
    }
}