<?php

declare(strict_types=1);

use Framework\Session\SessionManager;

$role = container(SessionManager::class)->get(SessionManager::USER_ROLE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Desk Management Page</title>
    <script defer src="/dist/js/deskManagement.53f19b82ef950d4a5ab0.js"></script></head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark navbar-expand-md sticky-top">
    <div class="container justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <a class="navbar-brand" href="#">LBX Desk Sharing</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="true" href="/overview">Overview</a>
                </li>
                <?php if ($role === "user" || $role === "teamlead" || $role === "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/booking/createBooking">Bookings</a>
                    </li>
                <?php endif; ?>
                <?php if ($role === "teamlead" || $role === "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/planning">Planning</a>
                    </li>
                <?php endif; ?>
                <?php if ($role === "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin">Admin</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container">
        <div class="row">
            <h1 class="col-12 text-center my-4">Desk Management</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <p class="text-center">There are <span id="tableAvailability">0</span> desks available</p>
            </div>
            <div class="col-12 col-md-8 order-md-first">
                <form class="form">
                    <div class="container">
                        <div class="row align-content-start g-0">
                            <div class="col-12 col-xl-8">
                                <div class="input-group">
                                    <span class="input-group-text">Date:</span>
                                    <input id="datepicker-1" type="date" aria-label="from date" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4">
                                <a id="search-btn" type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <canvas id="seatmap" class="col-12">Canvas not supported by your browser, please update</canvas>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-primary col-12 col-sm-2 my-4" id="enable-disable">Disable booking</button>
        </div>
    </div>
</main>

<footer class="bg-dark text-light mt-auto">
    <div class="container">
        <div class="row m-0 py-3 text-center">
            <p>Share Desk App</p>
        </div>
    </div>
</footer>

</body>
</html>