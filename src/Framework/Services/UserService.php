<?php

namespace Framework\Services;

use Framework\DAOs\UserDAO;

class UserService
{
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = container(UserDAO::class);
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

    public function createUser(array $user): int
    {
        $user['password'] = password_hash('test@123', PASSWORD_DEFAULT); // TODO: see how to set a default password and send email to user in order to change it
        return $this->userDAO::insert($user);
    }
}