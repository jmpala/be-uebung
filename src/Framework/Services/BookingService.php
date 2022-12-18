<?php

namespace Framework\Services;

use Framework\DAOs\BookingDAO;

class BookingService
{
    private BookingDAO $bookingDAO;

    public function __construct()
    {
        $this->bookingDAO = container(BookingDAO::class);
    }

    public function getTodayBookedDesks(): array
    {
        return $this->bookingDAO->getTodayBookedDesks();
    }

    public function getBookings(): array
    {
        throw new \Exception("Not implemented yet");
        return [];
    }

    public function getBooking(int $id): array
    {
        throw new \Exception("Not implemented yet");
        return [];
    }

    public function createBooking(array $booking): int
    {
        throw new \Exception("Not implemented yet");
        return 0;
    }

    public function updateBooking(array $booking): void
    {
        throw new \Exception("Not implemented yet");
    }

    public function deleteBooking(int $id): void
    {
        throw new \Exception("Not implemented yet");
    }
}