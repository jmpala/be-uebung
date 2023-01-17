<?php

namespace Webapp\Controllers\Booking;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;

class ShowBookingCreationController implements Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = container(Response::class);
    }


    public function handle(Request $request): Response
    {
        $this->response->statusCode(StatusCode::OK);
        return handleView('booking/booking-create.simplephp.php', []);
    }
}