<?php

namespace Framework\Services;

use Firebase\JWT\JWT;
use Framework\DAOs\UserDAO;

class LoginService
{
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = container(UserDAO::class);
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userDAO->selectByEmail($email);
        if (is_null($user)) {
            return false;
        }
        return password_verify($password, $user['password']);
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