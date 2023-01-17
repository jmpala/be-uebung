<?php

use Framework\Session\SessionManager;

$role = container(SessionManager::class)->get(SessionManager::USER_ROLE);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/dist/img/favicon.png">
    <title>Overview Page</title>
    <script defer src="/dist/js/overview.5fa5d8d69c48333a6195.js"></script></head>
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
                    <a class="nav-link active" aria-current="true" href="#">Overview</a>
                </li>
                <?php if ($role === "usr" || $role === "tml" || $role === "adm") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bookings</a>
                    </li>
                <?php endif; ?>
                <?php if ($role === "tml" || $role === "adm") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Planning</a>
                    </li>
                <?php endif; ?>
                <?php if ($role === "adm") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admin</a>
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
            <nav class="my-4 col-12 d-flex justify-content-around" aria-label="breadcrumb">
                <div class="d-flex py-2 px-3 border rounded">
                    <ol class="breadcrumb m-0 justify-content-center">
                        <li class="breadcrumb-item">Booking</li>
                        <li class="breadcrumb-item active">Confirmation</li>
                        <li class="breadcrumb-item">Booked</li>
                    </ol>
                </div>
            </nav>
        </div>
        <div class="row justify-content-around">
            <div class="col-8 py-3 border rounded">
                <p class="text-center">Date: <?= $bookingDate ?></p>
                <p class="text-center">Desk: <?= $deskName ?></p>
            </div>
        </div>
        <div>
            <form class="row justify-content-around" action="/booking/processNewBooking" method="POST">
                <input type="hidden" name="bookingDate" value="<?= $bookingDate ?>">
                <input type="hidden" name="deskName" value="<?= $deskName ?>"> <!-- TODO: do I need this? -->
                <input type="hidden" name="deskID" value="<?= $deskID ?>">
                <input class="btn btn-primary col-2 my-4" id="confirmBtn" type="submit" value="Confirm booking">
            </form>
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