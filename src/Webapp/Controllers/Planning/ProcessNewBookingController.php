<?php

namespace Webapp\Controllers\Planning;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;

class ProcessNewBookingController implements Controller
{
    private BookingService $bookingService;
    private Response $response;

    public function __construct()
    {
        $this->bookingService = container(BookingService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $userId = $request->getPostParam('userID');
        $deskId = $request->getPostParam('deskID');
        $bookingDate = $request->getPostParam('bookingDate');
        $deskName = $request->getPostParam('deskName');
        $userName = $request->getPostParam('userName');

        $res = $this->bookingService->createBooking([
            'user_id' => $userId,
            'desk_id' => $deskId,
            'start_date' => $bookingDate,
        ]);

        $this->response->statusCode(StatusCode::OK);
        return handleView('planning/booking-details.simplephp.php', [
            'deskName' => $deskName,
            'userName' => $userName,
            'bookingDate' => $bookingDate,
            'confirmation' => $res,
            'userID' => $userId,
        ]);
    }
}