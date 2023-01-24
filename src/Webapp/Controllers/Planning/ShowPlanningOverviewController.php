<?php

declare(strict_types=1);

namespace Webapp\Controllers\Planning;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\BookingService;
use Framework\Services\UserService;
use Framework\Session\SessionManager;

class ShowPlanningOverviewController implements Controller
{
    private SessionManager $sessionManager;
    private BookingService $bookingService;
    private UserService $userService;
    private Response $response;

    public function __construct()
    {
        $this->sessionManager = container(SessionManager::class);
        $this->userService = container(UserService::class);
        $this->bookingService = container(BookingService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        // we need all users for the combobox
        $users = $this->userService->getAllUsers();

        if ($request->existURIParam('userpage')) { // TODO: my eyes this is horrible, need to refactor the router!!!!
            $userpage = $request->getURIParam('userpage');
            $userpage = explode('&', $userpage);
            $user_id = $userpage[0];
            $currentUserId = explode('=', $user_id)[1];
            $page = $userpage[1];
            $currentPage = explode('=', $page)[1];
        } else {
            $currentPage = 1;

            // we need the current user for first load
            // wwe need the to fetch the uśer from the form
            if ($request->existPostParam('find-user')) {
                $currentUserId = $request->getPostParam('find-user');
            } else {
                $currentUserId = $this->sessionManager->get(SessionManager::USER_ID);
            }
        }

        $currentUser = $this->userService->getUserById($currentUserId);

        $bookings = $this->bookingService->getBookingsByUserIdPerPage($currentUserId, $currentPage);
        $totalBookings = $this->bookingService->getTotalNumberOfBookingByUserId($currentUserId);

        // TODO: Refactor pages to a helper class?
        $totalPages = ceil($totalBookings / configs('pagination.bookings_per_page'));
        $previousPage = $currentPage - 1 >= 1 ? $currentPage - 1 : null;
        $nextPage = $currentPage + 1 <= $totalPages ? $currentPage + 1 : null;

        $this->response->statusCode(StatusCode::OK);
        return handleView('planning/overview.simplephp.php', [
            'bookings' =>$bookings,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage,
            'users' => $users,
            'currentUser' => $currentUser,
        ]);
    }
}