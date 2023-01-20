<?php

namespace integration\DAOs;

use Cassandra\Date;
use Framework\DAOs\BookingDAO;
use PHPUnit\Framework\TestCase;

class BookingDAOIntegrationTest extends TestCase
{
    public function test_select_all_bookings_from_table(): void
    {
        $users = BookingDAO::selectAll();
        self::assertTrue($this->count($users) > 0);
    }

    public function test_insert_booking(): void
    {
        $startDate = time();
        $endDate = time() + 24 * 60 * 60;

        $booking = [
            'user_id' => 1,
            'desk_id' => 1,
            'start_date' => new \DateTime(),
            'end_date' => new \DateTime()
        ];


        $id = BookingDAO::insert($booking);
        $savedBooking = BookingDAO::selectById($id);

        self::assertEquals($booking['user_id'], $savedBooking['user_id']);
    }

    public function test_get_booking_by_id(): void
    {
        $booking = BookingDAO::selectById(1);
        self::assertNotNull($booking);
    }

    public function test_update_booking(): void
    {
        $booking = BookingDAO::selectById(1);
        $startDate = time();
        $endDate = time() + 24 * 60 * 60;

        $booking['start_date'] = date('Y-m-d H:i:s', $startDate);
        $booking['end_date'] = date('Y-m-d H:i:s', $endDate);
        BookingDAO::update($booking);
        $res = BookingDAO::selectById(1);
        self::assertEquals($booking['start_date'], $res['start_date']);
        self::assertEquals($booking['end_date'], $res['end_date']);
    }

    public function test_delete_booking_by_id(): void
    {
        $booking = [
            'user_id' => 1,
            'desk_id' => 1,
            'start_date' => new \DateTime(),
            'end_date' => new \DateTime()
        ];
        $id = BookingDAO::insert($booking);
        self::assertTrue(BookingDAO::isCreated($id));
        BookingDAO::deleteById($id);
        self::assertFalse(BookingDAO::isCreated($id));
    }

    public function test_delete_booking(): void
    {
        $booking = [
            'user_id' => 1,
            'desk_id' => 1,
            'start_date' => new \DateTime(),
            'end_date' => new \DateTime()
        ];
        $id = BookingDAO::insert($booking);
        $toDelete = BookingDAO::selectById($id);
        self::assertTrue(BookingDAO::isCreated($id));
        BookingDAO::delete($toDelete);
        self::assertFalse(BookingDAO::isCreated($id));
    }
}