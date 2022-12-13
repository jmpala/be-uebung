<?php

namespace Webapp\Controllers\Overview;

use Framework\Contracts\Controller;
use Framework\DAOs\BookingDAO;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Session\SessionManager;

class ShowOverviewPageController implements Controller
{

    public function handle(Request $request): Response
    {
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