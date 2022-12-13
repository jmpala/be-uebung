<?php

namespace Framework\DAOs;

use Framework\Contracts\DAO;

class RoleDAO implements DAO
{

    public static function getTable(): string
    {
        return 'roles';
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

    public static function selectAll(): array
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . ";";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function insert(array $dao): int
    {
        [
            'code' => $code,
            'name' => $name
        ] = $dao;
        $conn = dbconn();
        $query = "INSERT INTO " . self::getTable() .
            " (code, name)" .
            " VALUES (:code, :name)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('code', $code);
        $stmt->bindValue('name', $name);
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public static function update(array $dao): void
    {
        [
            'id' => $id,
            'code' => $code,
            'name' => $name
        ] = $dao;
        $conn = dbconn();
        $query = "UPDATE " . self::getTable() .
            " SET code = :code, name = :name" .
            " WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('id', $id);
        $stmt->bindValue('code', $code);
        $stmt->bindValue('name', $name);
        $stmt->execute();
    }

    public static function delete(array $dao): void
    {
        self::deleteById($dao['id']);
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
        return $stmt->fetchColumn() > 0;
    }
}