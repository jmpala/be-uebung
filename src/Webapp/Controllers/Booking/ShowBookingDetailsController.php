<?php

namespace Webapp\Controllers\Booking;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;
use Framework\Services\DeskService;

class ShowBookingDetailsController implements Controller
{
    private BookingService $bookingService;
    private DeskService $deskService;
    private Response $response;

    public function __construct()
    {
        $this->bookingService = container(BookingService::class);
        $this->deskService = container(DeskService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $bookingID = $request->getURIParam('id');
        $booking = $this->bookingService->getBookingById($bookingID);
        $deskName = $this->deskService->getDeskName($booking['desk_id']);
        $this->response->statusCode(StatusCode::OK);
        return handleView('/booking/booking-details.simplephp.php',[
            'booking' => $booking,
            'deskName' => $deskName,
        ]);
    }
}