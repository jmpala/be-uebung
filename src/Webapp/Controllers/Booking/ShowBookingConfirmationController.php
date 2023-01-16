<?php

namespace Webapp\Controllers\Booking;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Services\DeskService;

class ShowBookingConfirmationController implements Controller
{
    private DeskService $deskService;
    private Response $response;

    public function __construct()
    {
        $this->deskService = container(DeskService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(200);

        $deskID = $request->getPostParam('selected-desk');
        $deskName = $this->deskService->getDeskName($deskID);
        $bookingDate = $request->getPostParam('selected-date');

        return handleView('booking/booking-confirmation.simplephp.php', [
            'deskID' => $deskID,
            'deskName' => $deskName,
            'bookingDate' => $bookingDate,
        ]);
    }
}