<?php

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ShowEditConfirmationController implements Controller
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
        $name = implode(' ', [$request->getPostParam('userName'), $request->getPostParam('userLastName')]);
        $email = $request->getPostParam('userEmail');
        $userID = $request->getPostParam('userID');
        $roleID = $request->getPostParam('userRoleID');

        $roleName = $this->userService->getRoleName($roleID);

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/editUserConfirmation.php',  [
            'name' => $name,
            'email' => $email,
            'userID' => $userID,
            'roleID' => $roleID,
            'roleName' => $roleName,
        ]);
    }
}