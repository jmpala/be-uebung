<?php

namespace RESTapi\Controllers\Desks;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;

class ProcessDisableDeskRESTController implements Controller
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
        $dateDesk = $request->getURIParam('dateDesk');
        $date = explode('&', $dateDesk)[0];
        $date = explode('=', $date)[1];
        $deskID = explode('&', $dateDesk)[1];
        $deskID = explode('=', $deskID)[1];

        $date = new \DateTime($date);

        $this->bookingService->toggleDesk($date, $deskID);

        $this->response->addHeader('Content-Type', 'application/json');
        $this->response->statusCode(StatusCode::OK);
        return $this->response;
    }
}