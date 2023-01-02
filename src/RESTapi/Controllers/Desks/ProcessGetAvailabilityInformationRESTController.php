<?php

namespace RESTapi\Controllers\Desks;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;
use Framework\Services\DeskService;

class ProcessGetAvailabilityInformationRESTController implements Controller
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
        // we get all the bookings for the requested date
        $date = $request->existURIParam('date') ? new \DateTime($request->getURIParam('date')) : new \DateTime();
        $bookings = '';

        if ( $request->existURIParam('date')) {
            $bookings = $this->bookingService->getBookingsByDate($date);
        } else {
            $bookings = $this->bookingService->getTodayBookedDesks();
        }

        // we get all the desks
        $desks = $this->deskService->getDesks();


        // we create an array with the date as key and the desks as value
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

        $this->response->addHeader('Content-Type', 'application/json');
        $this->response->statusCode(StatusCode::OK);
        return $this->response->content(json_encode($availability));
    }
}