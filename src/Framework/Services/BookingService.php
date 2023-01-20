<?php

namespace Framework\Services;

use Framework\DAOs\BookingDAO;
use Framework\DAOs\UserDAO;

class BookingService
{
    private UserDAO $userDAO;
    private BookingDAO $bookingDAO;
    private DeskService $deskService;

    public function __construct()
    {
        $this->userDAO = container(UserDAO::class);
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

    public function getBookingById(int $id): array
    {
        return $this->bookingDAO::selectById($id);
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
        $this->bookingDAO::deleteById($id);
    }
    
    public function toggleDesk(\DateTime $date, int $deskID): void
    {
        try {
            $booking = $this->bookingDAO::getBookingByDateAndDeskId($date, $deskID);
            if ($booking) {
                $this->bookingDAO::deleteById($booking['id']);
            } else {
                $blockUser = $this->userDAO::selectByEmail(configs('availability_utils.block_availability_user'));
                $this->bookingDAO::insert([
                    'start_date' => $date,
                    'desk_id' => $deskID,
                    'user_id' => $blockUser['id'],
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Error while toggling desk: " . $e->getMessage());
        }
    }
}