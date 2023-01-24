<?php

declare(strict_types=1);

namespace Framework\Services;

use Framework\DAOs\RoleDAO;
use Framework\DAOs\UserDAO;
use Framework\DAOs\UsersRolesDAO;

class UserService
{
    private UserDAO $userDAO;
    private RoleDAO $roleDAO;
    private UsersRolesDAO $usersRolesDAO;

    public function __construct()
    {
        $this->userDAO = container(UserDAO::class);
        $this->roleDAO = container(RoleDAO::class);
        $this->usersRolesDAO = container(UsersRolesDAO::class);
    }

    public function getAllUsers(): array
    {
        return $this->userDAO::selectAll();
    }

    public function getUserById(int $id): array
    {
        return $this->userDAO::selectById($id);
    }

    public function getUserName(int $id): string
    {
        return $this->userDAO::selectById($id)['name'];
    }

    public function getAllUsersPerPage(int $page): array
    {
        return $this->userDAO::getAllUsersPerPage($page);
    }

    public function getTotalNumberOfUsers(): int
    {
        return $this->userDAO::getTotalNumberOfUsers();
    }

    public function createUser(array $user, int $roleId): int
    {
        $user['password'] = password_hash('test@123', PASSWORD_DEFAULT); // TODO: see how to set a default password and send email to user in order to change it
        $newUserID = $this->userDAO::insert($user);

        if ($roleId === 3) { // TODO: million dollar FANG code, please dont share
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 1]);
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 2]);
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 3]);
        } else if ($roleId === 2) {
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 1]);
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 2]);
        } else {
            $this->usersRolesDAO::insert(['user_id' => $newUserID, 'role_id' => 1]);
        }

        return $newUserID;
    }

    public function removeById(int $id): void
    {
        $this->userDAO::deleteById($id);
    }

    public function getAvailableRoles(): array
    {
        return $this->roleDAO::selectAll();
    }

    public function getRoleName(int $id): string
    {
        return $this->roleDAO::selectById($id)['name'];
    }

    public function updateUser(array $user, int $roleID): bool
    {
        $changed = $this->userDAO::update($user);

        $this->usersRolesDAO::deleteByUserId($user['id']);

        if ($roleID === 3) { // TODO: million dollar FANG code, please dont share
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 1]);
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 2]);
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 3]);
        } else if ($roleID === 2) {
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 1]);
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 2]);
        } else {
            $this->usersRolesDAO::insert(['user_id' => $user['id'], 'role_id' => 1]);
        }

        return $changed;
    }
}