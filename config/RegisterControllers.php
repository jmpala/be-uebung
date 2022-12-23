<?php

return [
    'GET:/' => \Webapp\Controllers\SampleController::class,
    'POST:/' => \Webapp\Controllers\SampleProcessController::class,
    'GET:/login' => \Webapp\Controllers\Login\ShowLoginPageController::class,
    'POST:/login' => \Webapp\Controllers\Login\ProcessLoginController::class,
    'GET:/logout' => \Webapp\Controllers\Login\ProcessLogoutController::class,
    'GET:/overview' => \Webapp\Controllers\Overview\ShowOverviewPageController::class,
    'GET:/overview/{?page}' => \Webapp\Controllers\Overview\ShowOverviewPageController::class,
    'staticFile:/{file}' => \Webapp\Controllers\StaticFilesController::class,
    'GET:/api/desks' => \Webapp\Controllers\SampleRestGETController::class,
];