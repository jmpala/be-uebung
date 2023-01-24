<?php

declare(strict_types=1);

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ShowNewUserController implements Controller
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
        $roles = $this->userService->getAvailableRoles();

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/newUser.php', [
            'roles' => $roles
        ]);
    }
}