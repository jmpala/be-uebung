<?php

namespace Webapp\Controllers\Booking;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;

class ProcessDeleteBookingController implements Controller
{
    private BookingService $bookingService;
    private Response $response;

    /**
     * @param BookingService $bookingService
     * @param Response $response
     */
    public function __construct()
    {
        $this->bookingService = container(BookingService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $id = $request->getURIParam('id');
        $this->bookingService->deleteBooking($id);
        $this->response->statusCode(StatusCode::OK);
        return redirect('/overview');
    }
}