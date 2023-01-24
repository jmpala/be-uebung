<?php

declare(strict_types=1);

namespace Webapp\Controllers\Booking;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Services\BookingService;
use Framework\Session\SessionManager;

class ProcessNewBookingController implements Controller
{
    private BookingService $bookingService;
    private SessionManager $sessionManager;

    public function __construct()
    {
        $this->bookingService = container(BookingService::class);
        $this->sessionManager = container(SessionManager::class);
    }

    public function handle(Request $request): Response
    {
        $deskID = $request->getPostParam('deskID');
        $bookingDate = $request->getPostParam('bookingDate');
        $userID = $this->sessionManager->get(SessionManager::USER_ID);

        $res = $this->bookingService->createBooking([ // TODO: better name for $res
            'desk_id' => $deskID,
            'user_id' => $userID,
            'start_date' => new \DateTime($bookingDate),
        ]);

        if ($res) {
            redirect('/booking/bookingDetails/' . $res);
        } else {
            redirect('/overview?error=bookingFailed');
        }
    }
}