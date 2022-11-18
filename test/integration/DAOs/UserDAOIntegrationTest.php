<?php

namespace integration\DAOs;

use Framework\DAOs\UserDAO;
use PHPUnit\Framework\TestCase;

class UserDAOIntegrationTest extends TestCase
{
    public function testSelectUserFromTable(): void
    {
        $user = UserDAO::selectById(1);
        self::assertNotNull($user);
    }

    public function testSelectAllUserFromTable(): void
    {
        $users = UserDAO::selectAll();
        self::assertTrue($this->count($users) > 0);
    }

    public function testInsertUser(): void
    {
        $user = [
            'name' => 'testUser',
            'password' => 'testUser',
            'email' => 'email@email.com'
        ];
        $id = UserDAO::insert($user);
        self::assertIsNumeric($id);
    }

    public function testUpdateUser(): void
    {
        $user = UserDAO::selectById(1);
        $user['password'] = random_int(10000000, 99999999);
        $lastChange = $user['last_changed_at'];
        UserDAO::update($user);
        $user = UserDAO::selectById(1);
        self::assertNotEquals($lastChange, $user['last_changed_at']);
    }

    public function testisCreatedAndDeleteUser(): void
    {
        $user = [
            'name' => 'testUser',
            'password' => 'testUser',
            'email' => 'email@email.com'
        ];
        $id = UserDAO::insert($user);
        self::assertTrue(UserDAO::isCreated($id));
        USERDAO::deleteById($id);
        self::assertFalse(UserDAO::isCreated($id));
    }
}