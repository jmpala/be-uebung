<?php

return [
    'GET:/' => \Webapp\Controllers\SampleController::class,
    'POST:/' => \Webapp\Controllers\SampleProcessController::class,
    'GET:/login' => \Webapp\Controllers\Login\ShowLoginPageController::class,
];