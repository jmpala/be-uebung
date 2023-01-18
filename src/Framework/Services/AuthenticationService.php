<?php

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
        $res = $this->usersRolesDAO->getRolesFromUserId($userId);

        foreach ($res as $role) {
            $roles[] = $role['code'];
        }

        return $roles;
    }
}