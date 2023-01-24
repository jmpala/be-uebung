<?php

declare(strict_types=1);

namespace Framework\Session;

// TODO: implement a commit method that will save the session data to the session storage
class SessionManager
{
    public CONST LOGGED_IN = 'logged_in';
    public CONST USER_ID = 'user_id';
    public CONST USER_ROLE = 'user_role';
    public CONST LAST_REQUEST_TIMESTAMP = 'last_request_timestamp';
    public CONST JWT_TOKEN = 'jwt_token';

    public function add(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key];
    }

    public function isKeySet(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function logIn(): void
    {
        $this->add(self::LOGGED_IN, true);
        session_regenerate_id(true);
    }

    public function logOut(): void
    {
        $this->add(self::LOGGED_IN, false);

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return $this->isKeySet(SessionManager::LOGGED_IN);
    }

    public function updateTimestamp(): void
    {
        $this->add(self::LAST_REQUEST_TIMESTAMP, time());
    }

}