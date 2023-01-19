<?php

namespace Webapp\Controllers\Admin;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\UserService;

class ShowAdminPanelController implements Controller
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
        if ($request->existURIParam('page')) {
            $currentPage = $request->getURIParam('page');
        } else {
            $currentPage = 1;
        }

        $users = $this->userService->getAllUsersPerPage($currentPage);
        $totalUsers = $this->userService->getTotalNumberOfUsers();

        // TODO: Refactor pages to a helper class?
        $totalPages = ceil($totalUsers / configs('pagination.users_per_page'));
        $previousPage = $currentPage - 1 >= 1 ? $currentPage - 1 : null;
        $nextPage = $currentPage + 1 <= $totalPages ? $currentPage + 1 : null;

        $this->response->statusCode(StatusCode::OK);
        return handleView('admin/adminPanel.php', [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage,
        ]);
    }
}