<?php

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
    <title>Admin Panel Page</title>
    <script defer src="/dist/js/adminPanel.165874a87f9125c9b626.js"></script></head>
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
            <h1 class="col-12 text-center my-4">Admin Panel</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-dark w-100" href="/admin/newUser">Create User</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-dark w-100" href="/admin/setAvailability">Set Availability</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr data-user-id="<?= $user['id'] ?>">
                            <th><?= $user['name'] ?></th>
                            <th><?= $user['email'] ?></th>
                            <th>
                                <a class="btn btn-primary btn-edit" href="/admin/userEdit/<?= $user['id'] ?>">Edit</a>
                                <button type="button" class="btn btn-primary btn-delete" data-bs-toggle="modal" data-bs-target="#deleteUserModal">Delete</button>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($totalPages > 1) : ?>
            <div class="row">
                <nav aria-label="existing bookings pagination">
                    <ul class="pagination justify-content-center">
                        <?php if ($previousPage) : ?>
                            <li class="page-item"><a class="page-link" href="/admin/<?= $previousPage ?>">Previous</a></li>
                        <?php endif; ?>
                        <li class="page-item active"><a class="page-link" href="#"><?= $currentPage ?></a></li>
                        <?php if ($nextPage) : ?>
                            <li class="page-item"><a class="page-link" href="/admin/<?= $nextPage ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="bg-dark text-light mt-auto">
    <div class="container">
        <div class="row m-0 py-3 text-center">
            <p>Share Desk App</p>
        </div>
    </div>
</footer>

<!-- Modals -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="delete user modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User ID: <span class="modal-label-id">#</span></h5>
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