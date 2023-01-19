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
    <title>Edit User Page</title>
    <script defer src="/dist/js/createUser.e7dbf0be9e124299d16d.js"></script></head>
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
            <nav class="my-4 col-12 d-flex justify-content-around" aria-label="breadcrumb">
                <div class="d-flex py-2 px-3 border rounded">
                    <ol class="breadcrumb m-0 justify-content-center">
                        <li class="breadcrumb-item active">Edit User</li>
                        <li class="breadcrumb-item">Confirmation</li>
                        <li class="breadcrumb-item">Edited</li>
                    </ol>
                </div>
            </nav>
        </div>
        <form class="create-user__form" action="/admin/user/edit/confirmation" method="POST">
            <div class="row justify-content-around">
                <div class="create-user__container col-8 px-2 py-4 border rounded">
                    <input type="text" id="userName" name="userName" class="create-user__first-name rounded-2 w-100" value="<?= explode(' ', $user['name'])[0] ?>" required>
                    <label for="userName" class="create-user__first-name-lbl w-100">First Name</label>
                    <input type="text" id="userLastName" name="userLastName" class="create-user__last-name rounded-2 w-100" value="<?= explode(' ', $user['name'])[1] ?>" required>
                    <label for="userLastName" class="create-user__last-name-lbl w-100">Last Name</label>
                    <input type="email" id="userEmail" name="userEmail" class="create-user__email rounded-2 w-100" value="<?= $user['email'] ?>" required>
                    <label for="userEmail" class="create-user__email-lbl w-100">Email</label>
                    <select class="form-select" id="userRole" name="userRoleID">
                        <?php foreach ($roles as $role) : ?>
                            <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="userID" id="userID" value="<?= $user['id'] ?>">
                </div>
            </div>
            <div class="row justify-content-around">
                <button id="confirmBtn" type="submit" class="create-user__submit-btn btn btn-primary col-2 my-4">Edit</button>
            </div>
        </form>
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