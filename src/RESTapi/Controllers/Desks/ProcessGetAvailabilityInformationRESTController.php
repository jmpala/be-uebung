<?php

namespace RESTapi\Controllers\Desks;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;

class ProcessGetAvailabilityInformationRESTController implements Controller
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
        // we get all the bookings for the requested date
        $date = $request->existURIParam('date') ? new \DateTime($request->getURIParam('date')) : new \DateTime();

        $availability = $this->bookingService->getAvailabilityInformationByDate($date);

        $this->response->addHeader('Content-Type', 'application/json');
        $this->response->statusCode(StatusCode::OK);
        return $this->response->content(json_encode($availability));
    }
}