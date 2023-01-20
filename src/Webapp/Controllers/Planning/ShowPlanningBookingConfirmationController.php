<?php

namespace Webapp\Controllers\Planning;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Services\DeskService;
use Framework\Services\UserService;

class ShowPlanningBookingConfirmationController implements Controller
{
    private UserService $userService;
    private DeskService $deskService;
    private Response $response;

    public function __construct()
    {
        $this->userService = container(UserService::class);
        $this->deskService = container(DeskService::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $userid = $request->getPostParam('selected-user');
        $desk_id = $request->getPostParam('selected-desk');
        $bookingDate = $request->getPostParam('selected-date');

        if (!$desk_id) { // TODO: see if this is a correct logic way of handling this case, only a lazy error handling until I decide how to handle errors in general
            return redirect('/planning');
        }

        $deskName = $this->deskService->getDeskName($desk_id);
        $userName = $this->userService->getUserName($userid);

        $this->response->statusCode(StatusCode::OK);
        return handleView('planning/booking-confirmation.simplephp.php', [
            'userName' => $userName,
            'userID' => $userid,
            'bookingDate' => $bookingDate,
            'deskID' => $desk_id,
            'deskName' => $deskName,
        ]);
    }
}