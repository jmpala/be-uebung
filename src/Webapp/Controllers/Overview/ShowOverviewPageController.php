<?php

namespace Webapp\Controllers\Overview;

use Framework\Contracts\Controller;
use Framework\DAOs\BookingDAO;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Services\BookingService;
use Framework\Session\SessionManager;

class ShowOverviewPageController implements Controller
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
        $this->response->statusCode(200);

        if ($request->existURIParam('page')) {
            $currentPage = $request->getURIParam('page');
        } else {
            $currentPage = 1;
        }

        $session = container(SessionManager::class);
        $userId = $session->get(SessionManager::USER_ID);
        $bookings = BookingDAO::getBookingsForUser($userId, $currentPage);
        $totalBookings = BookingDAO::getTotalBookingsForUser($userId);

        $totalPages = ceil($totalBookings / configs('pagination.bookings_per_page'));
        $previousPage = $currentPage - 1 >= 1 ? $currentPage - 1 : null;
        $nextPage = $currentPage + 1 <= $totalPages ? $currentPage + 1 : null;

        return handleView('overview/overview.simplephp.php',[
            'bookings' =>$bookings,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage
        ]);
    }
}