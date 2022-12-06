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
        UserDAO::update($user);
        $res = UserDAO::selectById(1);
        self::assertEquals($user['password'], $res['password']);
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

    public function testSelectUserByEmail(): void
    {
        $user = [
            'name' => 'testUser',
            'password' => 'testUser',
            'email' => 'email@email.com'
        ];
        $id = UserDAO::insert($user);
        $res = UserDAO::selectByEmail($user['email']);
        self::assertNotNull($user);
        self::assertEquals($user['email'], $res['email']);
    }
}