<?php

namespace Framework\Middleware\Authentication;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;
use Framework\Session\SessionManager;


class AuthenticationMidd extends AbstractHandler
{
    private int $secondsBeforeIdRegen;
    private int $secondsBeforeSessionExpire;

    private array $publicRoutes;

    public function __construct()
    {
        $this->secondsBeforeIdRegen = configs('middleware.authentication.sec_regenerate_session');
        $this->secondsBeforeSessionExpire = configs('middleware.authentication.sec_expire_session');

        $this->publicRoutes = include __DIR__ . '/../../../../config/appPublicRoutes.php';
    }

    protected function process(Request $request): Request
    {
        $sessionManager = container(SessionManager::class);

        if (in_array($request->uri(), $this->publicRoutes)) {
            return $request;
        }

        $this->checkIfRequestIsREST($request);
        if ($request->isREST()) {
            $this->checkIfValidJWT($request);
            return $request;
        }

        $this->checkIfLoggedIn($sessionManager, $request);
        $this->checkTimestampOrCreate($sessionManager);
        $this->checkSessionExpire($sessionManager);
        $this->regenerateSessionId($sessionManager);

        return $request;
    }

    private function checkIfLoggedIn(SessionManager $sessionManager, Request $request): void
    {
        if (in_array($request->uri(), $this->publicRoutes, false)) {
            return;
        }

        if (!$sessionManager->isLoggedIn()) {
            redirect('/login');
        }
    }

    private function checkTimestampOrCreate(SessionManager $sessionManager): void
    {
        if (!$sessionManager->isKeySet(SessionManager::LAST_REQUEST_TIMESTAMP)) {
            $sessionManager->updateTimestamp();
        }
    }

    private function checkSessionExpire(SessionManager $sessionManager): void
    {
        if (time() - $sessionManager->get(SessionManager::LAST_REQUEST_TIMESTAMP) > $this->secondsBeforeSessionExpire) {
            $sessionManager->logOut();
            redirect('/login');
        }
    }

    private function regenerateSessionId(SessionManager $sessionManager): void
    {
        if ($sessionManager->isLoggedIn() && time() - $sessionManager->get(SessionManager::LAST_REQUEST_TIMESTAMP) > $this->secondsBeforeIdRegen) {
            $sessionManager->logIn();
        }
    }

    private function checkIfRequestIsREST(Request $request)
    {
        $uri = $request->uri();
        $isREST = preg_match('#/api/#', $uri) === 1;
        $request->isREST($isREST);
    }

    private function checkIfValidJWT(Request $request)
    {
        $jwt_token = $request->jwtToken();
        JWT::decode($jwt_token, new Key(configs('restapi.secret.key'), configs('restapi.cypher.algorithm')));
    }

}