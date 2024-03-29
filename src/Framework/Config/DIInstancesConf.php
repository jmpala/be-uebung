<?php

/*
 * Framework specific classes to be loaded into the DIContainer
 */
return [
    \Framework\Http\Request::class,
    \Framework\Http\Response::class,
    \Framework\Router\Router::class,
    \Framework\View\Manager::class,
    \Framework\Session\SessionManager::class,

    // Middleware
    \Framework\Middleware\Middleware::class,

    // DAOs
    \Framework\DAOs\BookingDAO::class,
    \Framework\DAOs\DesksDAO::class,
    \Framework\DAOs\UserDAO::class,
    \Framework\DAOs\RoleDAO::class,
    \Framework\DAOs\UsersRolesDAO::class,

    // Services
    \Framework\Services\BookingService::class,
    \Framework\Services\DeskService::class,
    \Framework\Services\LoginService::class,
    \Framework\Services\AuthenticationService::class,
    \Framework\Services\UserService::class,
];