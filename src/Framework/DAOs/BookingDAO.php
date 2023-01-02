<?php

namespace Framework\DAOs;

use Framework\Contracts\DAO;

class BookingDAO implements DAO
{
    public static function getTable(): string
    {
        return 'bookings';
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
            'user_id' => $userId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ] = $dao;
        $conn = dbconn();
        $query = "INSERT INTO " . self::getTable() .
            " (user_id, start_date, end_date)" .
            " VALUES (:user_id, :start_date, :end_date)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId);
        $stmt->bindValue('start_date', $startDate);
        $stmt->bindValue('end_date', $endDate);
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public static function update(array $dao): void
    {
        [
            'id' => $id,
            'user_id' => $userId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ] = $dao;
        $conn = dbconn();
        $query = "UPDATE " . self::getTable() .
            " SET user_id = :user_id, start_date = :start_date, end_date = :end_date" .
            " WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('id', $id);
        $stmt->bindValue('user_id', $userId);
        $stmt->bindValue('start_date', $startDate);
        $stmt->bindValue('end_date', $endDate);
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
        $res = $stmt->fetch(\PDO::FETCH_NUM)[0];
        return $res !== "0";
    }

    public static function getBookingsForUser($userId, mixed $page)
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . " WHERE user_id = :user_id LIMIT :limit OFFSET :offset;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', configs('pagination.bookings_per_page'), \PDO::PARAM_INT);
        $stmt->bindValue('offset', ($page - 1) * configs('pagination.bookings_per_page'), \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getTotalBookingsForUser($userId)
    {
        $conn = dbconn();
        $query = "SELECT COUNT(*) FROM " . self::getTable() . " WHERE user_id = :user_id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_NUM)[0];
    }

    public static function getTodayBookedDesks(): array
    {
        return self::getBookedDesksForDate(new \DateTime());
    }

    public static function getBookedDesksForDate(\DateTime $date): array
    {
        $conn = dbconn();
        $query = "SELECT desks.code, bookings.user_id, bookings.desk_id, bookings.start_date, bookings.end_date  FROM desks
                    INNER JOIN bookings
                    ON desks.id = bookings.desk_id
                    WHERE :date BETWEEN bookings.start_date AND bookings.end_date  
                    ORDER BY `desks`.`code` ASC";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('date', $date->format('Y-m-d'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}