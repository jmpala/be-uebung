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
    <title>Confirmed User Page</title>
    <script defer src="/dist/js/confirmedUser.82d9792c2abac3d65828.js"></script></head>
</head>
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
                    <a class="nav-link" aria-current="true" href="#">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Planning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
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
                        <li class="breadcrumb-item">New User</li>
                        <li class="breadcrumb-item">Confirmation</li>
                        <li class="breadcrumb-item active">Created</li>
                    </ol>
                </div>
            </nav>
        </div>
        <div class="row justify-content-around">
            <div class="col-8 border py-3 rounded">
                <p class="text-center">User-ID: <?= $id ?></p>
                <p class="text-center">Name: <?= $name ?></p>
                <p class="text-center">Email: <?= $email ?></p>
                <p class="text-center">Role: <?= $roleName ?></p>
            </div>
        </div>
        <div class="row justify-content-around">
            <a id="confirmBtn" type="button" class="btn btn-primary col-2 my-4" href="/admin">To Admin Panel</a>
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