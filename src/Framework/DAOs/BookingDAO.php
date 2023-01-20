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
            'desk_id' => $deskId,
            'start_date' => $startDate,
            'start_date' => $endDate
        ] = $dao;
        $conn = dbconn();
        $query = "INSERT INTO " . self::getTable() .
            " (user_id, desk_id, start_date, end_date)" .
            " VALUES (:user_id, :desk_id, :start_date, :end_date)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('user_id', $userId);
        $stmt->bindValue('desk_id', $deskId);
        $stmt->bindValue('start_date', $startDate->format('Y-m-d'));
        $stmt->bindValue('end_date', $endDate->format('Y-m-d'));
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public static function update(array $dao): bool
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
        return $stmt->execute();
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
        $query = "SELECT b.id, b.user_id, b.start_date, b.end_date, b.created_at, b.updated_at, d.id as desk_id, d.code as desk_code
            FROM " . self::getTable() . " as b 
            INNER JOIN " . DesksDAO::getTable() . " as d 
            ON b.desk_id = d.id 
            WHERE b.user_id = :user_id
            LIMIT :limit
            OFFSET :offset;";
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

    public static function getBookingByDateAndDeskId(\DateTime $date, int $deskID): array
    {
        $conn = dbconn();
        $query = "SELECT * FROM " . self::getTable() . " WHERE start_date = :start_date AND desk_id = :desk_id;"; // TODO: in case of booking for multiple days, review code!
        $stmt = $conn->prepare($query);
        $stmt->bindValue('start_date', $date->format('Y-m-d'));
        $stmt->bindValue('desk_id', $deskID);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}