<?php

namespace Framework\Middleware\Authentication;

use Framework\Http\Request;
use Framework\Middleware\AbstractHandler;
use Framework\Session\SessionManager;


class AuthenticationMidd extends AbstractHandler
{
    // TODO: send to config file
    private int $secondsBeforeIdRegen = 300;
    private int $secondsBeforeSessionExpire = 360;

    protected function process(Request $request): Request
    {
        $sessionManager = container(SessionManager::class);

        $this->checkTimestampOrCreate($sessionManager);
        $this->checkSessionExpire($sessionManager);
        $this->regenerateSessionId($sessionManager);

        return $request;
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
        }
    }

    private function regenerateSessionId(SessionManager $sessionManager): void
    {
        if (time() - $sessionManager->get(SessionManager::LAST_REQUEST_TIMESTAMP) > $this->secondsBeforeIdRegen) {
            $sessionManager->logIn();
        }
    }

}