<?php

declare(strict_types=1);

namespace Framework\Services;

use Framework\DAOs\UsersRolesDAO;
use Framework\Session\SessionManager;

class AuthenticationService
{
    private SessionManager $sessionManager;
    private UsersRolesDAO $usersRolesDAO;

    public function __construct()
    {
        $this->sessionManager = container(SessionManager::class);
        $this->usersRolesDAO = container(UsersRolesDAO::class);
    }

    public function getRoles(): array
    {
        $roles = [];
        $userId = $this->sessionManager->get(SessionManager::USER_ID);

        $userId = is_string($userId) ? (int) $userId : $userId;
        $res = $this->usersRolesDAO->getRolesFromUserId($userId);

        foreach ($res as $role) {
            $roles[] = $role['code'];
        }

        return $roles;
    }
}