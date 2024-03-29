<?php

namespace Framework\DAOs;

use Framework\Contracts\DAO;

class UsersRolesDAO implements DAO
{

    public static function getTable(): string
    {
        return 'users_roles';
    }

    public static function selectById(int $id): array
    {
        throw new \Exception('Not implemented');
    }

    public static function selectAll(): array
    {
        throw new \Exception('Not implemented');
    }

    public static function insert(array $dao): int
    {
        [
            'user_id' => $userId,
            'role_id' => $roleId
        ] = $dao;
        $conn = dbconn();
        $query = "INSERT INTO users_roles (user_id, role_id) VALUES (:user_id, :role_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue('role_id', $roleId, \PDO::PARAM_INT);
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public static function update(array $dao): bool
    {
        throw new \Exception('Not implemented');
    }

    public static function delete(array $dao): void
    {
        throw new \Exception('Not implemented');
    }

    public static function deleteById(int $id): void
    {
        throw new \Exception('Not implemented');
    }

    public static function deleteByUserId(int $userId): void
    {
        $conn = dbconn();
        $query = "DELETE FROM " . self::getTable() . " WHERE user_id = :user_id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function isCreated(int $id): bool
    {
        throw new \Exception('Not implemented');
    }

    public static function getRolesFromUserId(int $userId): array
    {
        $conn = dbconn();
        $query = "SELECT ur.user_id, ur.role_id, r.code, r.name
                    FROM users_roles as ur
                    INNER JOIN roles as r
                    ON ur.role_id = r.id
                    WHERE ur.user_id = :user_id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}