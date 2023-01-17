<?php

namespace Framework\Services;

use Framework\DAOs\BookingDAO;

class BookingService
{
    private BookingDAO $bookingDAO;
    private DeskService $deskService;

    public function __construct()
    {
        $this->bookingDAO = container(BookingDAO::class);
        $this->deskService = container(DeskService::class);
    }

    public function getAvailabilityInformationByDate(\DateTime $date): array
    {
        $bookings = $this->getBookingsByDate($date);
        $desks = $this->deskService->getDesks();

        $availability = [
            $date->format('Y-m-d') => []
        ];

        foreach ($desks as $desk) {
            $availability[$date->format('Y-m-d')][$desk['code']] = [
                'id' => $desk['id'],
                'pos' => [
                    'x' => $desk['pos_x'],
                    'y' => $desk['pos_y'],
                ],
                'size' => [
                    'w' => $desk['width'],
                    'h' => $desk['height'],
                ],
                'isBooked' => false,
            ];
        }

        foreach ($bookings as $booking) {
            foreach ($availability[$date->format('Y-m-d')] as $key => $desk) {
                if ($desk['id'] === $booking['desk_id']) {
                    $availability[$date->format('Y-m-d')][$key]['isBooked'] = true;
                }
            }
        }

        return $availability;
    }

    public function getTodayBookedDesks(): array
    {
        return $this->bookingDAO->getTodayBookedDesks();
    }

    public function getBookingsByDate(\DateTime $date): array
    {
        return $this->bookingDAO->getBookedDesksForDate($date);
    }

    public function getBookingsByUserIdPerPage(int $userId, int $page): array
    {
        return $this->bookingDAO::getBookingsForUser($userId, $page);
    }

    public function getTotalNumberOfBookingByUserId(int $userId): int
    {
        return (int) $this->bookingDAO::getTotalBookingsForUser($userId);
    }

    public function createBooking(array $booking): int
    {
        return $this->bookingDAO::insert($booking);
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