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
    <title>Planning Page</title>
    <script defer src="/dist/js/planning.543ccd12d196286a00fc.js"></script></head>
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
                        <a class="nav-link active" href="/planning">Planning</a>
                    </li>
                <?php endif; ?>
                <?php if ($role === "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
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
            <h1 class="col-12 text-center my-4">Seat Planning</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <p class="text-center">There are <span id="tableAvailability">0</span> desks available</p>
            </div>
            <form class="row col-12 col-md-4" action="/planning" method="POST">
                <div class="row col-8">
                    <select class="form-select" name="find-user" id="find-user">
                        <?php if (empty($users)): ?>
                        <option selected>No users loaded...</option>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="row col-4">
                    <input type="submit" value="Select">
                </div>
            </form>
            <div class="col-12 col-md-4 order-md-first">
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
            <form class="row justify-content-center" action="/planning/confirmation" method="POST">
                <input type="hidden" id="selected-user" name="selected-user" value="">
                <input type="hidden" id="selected-desk" name="selected-desk" value="">
                <input type="hidden" id="selected-date" name="selected-date" value="">
                <input class="btn btn-primary col-12 col-sm-2 my-4" id="new-booking" type="submit" value="New Booking">
            </form>
        </div>
    </div>
</main>

<section class="my-4">
    <div class="container">
        <div class="row">
            <h1 class="col-12 text-center my-4">Existing Bookings from: <?= $currentUser['name'] ?></h1>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table id="bookings-table" class="table table-striped align-middle text-center">
                    <thead>
                    <tr>
                        <th>Desk</th>
                        <th>Date</th>
                        <th>Confirmation</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php if (empty($bookings)) : ?>
                        <tr>
                            <td colspan="4">No bookings found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking) : ?>
                            <tr data-booking-id="<?= $booking['id'] ?>">
                                <th><?= $booking['desk_code'] ?></th>
                                <th><?= $booking['start_date'] ?></th>
                                <th><?= $booking['id'] ?></th>
                                <th>
                                    <!--                                        <a class="btn btn-primary btn-edit" href="#0">Edit</a>-->
                                    <button type="button" class="btn btn-primary btn-delete" data-bs-toggle="modal" data-bs-target="#deleteBookingModal">Delete</button>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($totalPages > 1) : ?>
            <div class="row">
                <nav aria-label="existing bookings pagination">
                    <ul class="pagination justify-content-center">
                        <?php if ($previousPage) : ?>
                            <li class="page-item"><a class="page-link" href="/planning/user=<?= $currentUser['id'] ?>&page=<?= $previousPage ?>">Previous</a></li>
                        <?php endif; ?>
                        <li class="page-item active"><a class="page-link" href="#"><?= $currentPage ?></a></li>
                        <?php if ($nextPage) : ?>
                            <li class="page-item"><a class="page-link" href="/planning/user=<?= $currentUser['id'] ?>&page=<?= $nextPage ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</section>

<footer class="bg-dark text-light mt-auto">
    <div class="container">
        <div class="row m-0 py-3 text-center">
            <p>Share Desk App</p>
        </div>
    </div>
</footer>

<!-- Modals -->
<div class="modal fade" id="deleteBookingModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="delete bookings modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Booking ID: <span class="modal-label-id">#</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you would like to delete this user? All its details are going to be removed from our system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger modal-btn-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>