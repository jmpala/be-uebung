<?php

namespace Framework\Session;

class SessionManager
{
    public CONST LOGGED_IN = 'logged_in';
    public CONST LAST_REQUEST_TIMESTAMP = 'last_request_timestamp';

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