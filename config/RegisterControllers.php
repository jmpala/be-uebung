<?php

return [
    'GET:/' => \Webapp\Controllers\SampleController::class,
    'POST:/' => \Webapp\Controllers\SampleProcessController::class,
    'GET:/login' => \Webapp\Controllers\Login\ShowLoginPageController::class,
    'POST:/login' => \Webapp\Controllers\Login\ProcessLoginController::class,
    'GET:/overview' => \Webapp\Controllers\Overview\ShowOverviewPageController::class,
    'staticFile:/{file}' => \Webapp\Controllers\StaticFilesController::class,
];