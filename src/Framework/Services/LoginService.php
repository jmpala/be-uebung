<?php

namespace Framework\Services;

use Firebase\JWT\JWT;
use Framework\DAOs\RoleDAO;
use Framework\DAOs\UserDAO;
use Framework\Session\SessionManager;
use http\Client\Curl\User;

class LoginService
{
    private SessionManager $sessionManager;

    public function __construct()
    {
        $this->sessionManager = container(SessionManager::class);
    }

    public function login(string $email, string $password): bool
    {
        $user = UserDAO::selectByEmail($email);
        if (is_null($user)) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $this->sessionManager->logIn();
        $this->sessionManager->add(SessionManager::USER_ID, $user['id']);

        $role = RoleDAO::selectById($user['role_id']);
        $this->sessionManager->add(SessionManager::USER_ROLE, $role['code']);

        $token = $this->generateJWTToken($user['password']);
        setcookie('jwttoken', $token, time() + 3600, '/', 'be-uebung.ddev.site', false, true); // TODO: refactor in config file & is there a better way to handle this?

        return true;
    }

    public function generateJWTToken(string $email): string
    {
        $payload = [
            "iss" => configs('restapi.payload.iss'),
            "sub" => $email,
            "aud" => configs('restapi.payload.aud'),
            "iat" => configs('restapi.payload.iat'),
            "exp" => configs('restapi.payload.exp'),
        ];
        $secret = configs('restapi.secret.key');
        $algorithm = configs('restapi.cypher.algorithm');
        return JWT::encode($payload, $secret, $algorithm);
    }
}