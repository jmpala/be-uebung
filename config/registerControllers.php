<?php

return [
    // Webapp
    'GET:/' => \Webapp\Controllers\SampleController::class,
    'POST:/' => \Webapp\Controllers\SampleProcessController::class,
    'staticFile:/{file}' => \Webapp\Controllers\StaticFilesController::class,

    // LOGIN
    'GET:/login' => \Webapp\Controllers\Login\ShowLoginPageController::class,
    'POST:/login' => \Webapp\Controllers\Login\ProcessLoginController::class,
    'GET:/logout' => \Webapp\Controllers\Login\ProcessLogoutController::class,

    // Overview
    'GET:/overview' => \Webapp\Controllers\Overview\ShowOverviewPageController::class,
    'GET:/overview/{?page}' => \Webapp\Controllers\Overview\ShowOverviewPageController::class,

    // Bookings
    'POST:/booking/confirmation' => \Webapp\Controllers\Booking\ShowBookingConfirmationController::class, // TODO: should this be a GET?
    'POST:/booking/processNewBooking' => \Webapp\Controllers\Booking\ProcessNewBookingController::class,
    'GET:/booking/bookingDetails/{id}' => \Webapp\Controllers\Booking\ShowBookingDetailsController::class,
    'POST:/booking/processDeleteBooking/{id}' => \Webapp\Controllers\Booking\ProcessDeleteBookingController::class,
    'GET:/booking/createBooking' => \Webapp\Controllers\Booking\ShowBookingCreationController::class,

    // Planning
    'GET:/planning' => \Webapp\Controllers\Planning\ShowPlanningOverviewController::class,
    'GET:/planning/{?userpage}' => \Webapp\Controllers\Planning\ShowPlanningOverviewController::class,
    'POST:/planning' => \Webapp\Controllers\Planning\ShowPlanningOverviewController::class,
    'POST:/planning/confirmation' => \Webapp\Controllers\Planning\ShowPlanningBookingConfirmationController::class, // TODO: should this be a GET?
    'POST:/planning/processNewBooking' => \Webapp\Controllers\Planning\ProcessNewBookingController::class,

    // Admnin
    'GET:/admin' => \Webapp\Controllers\Admin\ShowAdminPanelController::class,
    'GET:/admin/{?page}' => \Webapp\Controllers\Admin\ShowAdminPanelController::class,
    'GET:/admin/user/create' => \Webapp\Controllers\Admin\ShowNewUserController::class, // TODO: fix, when "GET:/admin/newUser", router resolves to "GET:/admin/{?page}"
    'POST:/admin/user/confirmation' => \Webapp\Controllers\Admin\ShowConfirmationController::class,
    'POST:/admin/user/processNewUser' => \Webapp\Controllers\Admin\ProcessNewUserController::class,
    'POST:/admin/user/processDeleteUser/{id}' => \Webapp\Controllers\Admin\ProcessDeleteUserController::class,
    'GET:/admin/user/edit/{id}' => \Webapp\Controllers\Admin\ShowEditUserController::class,
    'POST:/admin/user/edit/confirmation' => \Webapp\Controllers\Admin\ShowEditConfirmationController::class,
    'POST:/admin/user/edit/process' => \Webapp\Controllers\Admin\ProcessEditUserController::class,

    // REST API
    'POST:/api/login' => \RESTapi\Controllers\Login\ProcessLoginRESTController::class,
    'GET:/api/desks/availability' =>  \RESTapi\Controllers\Desks\ProcessGetAvailabilityInformationRESTController::class,
    'GET:/api/desks/availability/{?date}' =>  \RESTapi\Controllers\Desks\ProcessGetAvailabilityInformationRESTController::class,
];