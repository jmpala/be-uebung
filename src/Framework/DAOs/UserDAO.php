<?php

declare(strict_types=1);

namespace Framework\DAOs;

use Framework\Contracts\DAO;

class UserDAO implements DAO
{

    public static function getTable(): string
    {
        return 'users';
    }

    public static function selectById(int $id): array
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . " WHERE id = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function selectByEmail(string $email): array | bool
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . " WHERE email = :email;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function selectAll(): array
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . ";";
        $stmt = $conn->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function insert(array $dao): int
    {
        [
            'name' => $name,
            'password' => $password,
            'email' => $email
        ] = $dao;
        $conn = dbconn();
        $query = "INSERT INTO " . self::getTable() .
            " (name, password, email)" .
            " VALUES (:name, :password, :email)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('name', $name);
        $stmt->bindValue('password', $password);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public static function update(array $dao): bool
    {
        [
            'id' => $id,
            'name' => $name,
            'email' => $email
        ] = $dao;
        $conn = dbconn();
        $query = "UPDATE " . self::getTable() .
            " SET name = :name, email = :email" .
            " WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('name', $name);
        $stmt->bindValue('email', $email);
        $stmt->bindValue('id', $id);
        return $stmt->execute();
    }

    public static function delete(array $dao): void
    {
        [
            'id' => $id
        ] = $dao;
        static::deleteById($id);
    }

    public static function deleteById(int $id): void
    {
        $conn = dbconn();
        $query = "DELETE FROM " . self::getTable() . " WHERE id = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function isCreated(int $id): bool
    {
        $conn = dbconn();
        $query = "SELECT COUNT(*) FROM " . self::getTable() . " WHERE id = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_NUM)[0];
        return $res !== "0";
    }

    public static function getAllUsersPerPage(int $page): array
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . " LIMIT :limit OFFSET :offset;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('limit', configs('pagination.users_per_page'), \PDO::PARAM_INT);
        $stmt->bindValue('offset', ($page - 1) * configs('pagination.users_per_page'), \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getTotalNumberOfUsers(): int
    {
        $conn = dbconn();
        $query = "SELECT COUNT(*) FROM " . self::getTable() . ";";
        $stmt = $conn->query($query);
        return $stmt->fetch(\PDO::FETCH_NUM)[0];
    }
}