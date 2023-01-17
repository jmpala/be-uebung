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

    // REST API
    'POST:/api/login' => \RESTapi\Controllers\Login\ProcessLoginRESTController::class,
    'GET:/api/desks/availability' =>  \RESTapi\Controllers\Desks\ProcessGetAvailabilityInformationRESTController::class,
    'GET:/api/desks/availability/{?date}' =>  \RESTapi\Controllers\Desks\ProcessGetAvailabilityInformationRESTController::class,
];