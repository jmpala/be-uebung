<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/dist/img/favicon.png">
    <title>Login Page</title>
<script defer src="/dist/js/login.5fa5d8d69c48333a6195.js"></script></head>
<body>

<main>
    <div class="container-md">
        <div class="row vh-100 justify-content-center align-content-center">
            <h1 class="text-center">LBX Desk Sharing</h1>
            <form class="loginform__form py-3 px-1 p-md-3 rounded-3" action="/login" method="post">
                <input type="text" id="email" name="email" class="loginform__username rounded-2 w-100" required>
                <label for="email" class="loginform__usernameLbl w-100">User Name</label>
                <input type="password" id="password" name="password" class="loginform__password rounded-2 w-100" required>
                <label for="password" class="loginform__passwordLbl w-100">Password</label>
                <button id="submit-btn" type="submit" class="btn loginform__btn">Submit</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>