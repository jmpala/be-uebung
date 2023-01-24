<?php

declare(strict_types=1);

namespace Framework\Middleware\Authorization;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\StatusCode;
use Framework\Middleware\AbstractHandler;
use Framework\Services\AuthenticationService;

class AuthorizationMidd extends AbstractHandler
{
    private AuthenticationService $authenticationService;
    private Response $response;

    private array $authRoutes;

    private array $publicRoutes;

    public function __construct()
    {
        $this->authenticationService = container(AuthenticationService::class);
        $this->response = container(Response::class);

        $this->publicRoutes = include __DIR__ . '/../../../../config/appPublicRoutes.php';
        $this->authRoutes = include __DIR__ . '/../../../../config/routePermissions.php';
    }

    protected function process(Request $request): Request
    {
        // we get the uri
        $uri = $request->uri();

        // excepted urls
        if (in_array($uri, $this->publicRoutes, true)) {
            return $request;
        }

        // we check if the uri is in the routes array
        $res = $this->isRouteAuthorized($uri);

        // if user has not valid role, return with error (401)
        if (!$res) {
            $this->response->statusCode(StatusCode::UNAUTHORIZED);
            $this->response->addHeader('HTTP/1.1 401', 'Unauthorized');
            exit('Unauthorized 401');
        }

        // if user has valid role, next middleware
        return $request;
    }

    private function isRouteAuthorized(string $uri) : bool
    {
        // get the user role
        $userRoles = $this->authenticationService->getRoles(); // ['user', 'teamlead', 'admin'] or any variation
        // relation between uri and role
        $role = $this->getRoleFromUri($uri);

        foreach ($userRoles as $userRole) {
            if ($userRole === $role) {
                return true;
            }
        }
        return false;
    }

    private function getRoleFromUri(string $uri) : string | false
    {
        // we get the first part of the uri
        $uri = explode('/', $uri)[1];
        // we check if the uri is in the routes array
        if (array_key_exists($uri, $this->authRoutes)) {
            return $this->authRoutes[$uri];
        }
        // if not, we return the default role
        return false;
    }

}