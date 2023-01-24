<?php

declare(strict_types=1);

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ShowConfirmationController implements Controller
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
        $name = implode( ' ', [$request->getPostParam('userName'), $request->getPostParam('userLastName')]);
        $email = $request->getPostParam('userEmail');
        $roleID = $request->getPostParam('userRoleID');

        $roleName = $this->userService->getRoleName($roleID);

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/newUserConfirmation.php', [
            'name' => $name,
            'email' => $email,
            'roleID' => $roleID,
            'roleName' => $roleName,
        ]);
    }
}