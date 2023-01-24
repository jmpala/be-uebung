<?php

declare(strict_types=1);

namespace Framework\Http;

class Request
{
    protected array $uriParams = [];
    protected array $postParams = [];

    protected string $method;
    protected string $uri;

    protected bool $isREST = false;
    protected string $jwtToken = '';

    public function __construct(){}

    public function method(string $value = null): string|static
    {
        if (is_null($value)) {
            return $this->method;
        }
        $this->method = $value;
        return $this;
    }

    public function uri(string $value = null): string|static
    {
        if (is_null($value)) {
            return $this->uri;
        }
        $this->uri = $value;
        return $this;
    }

    public function isREST(bool $value = null): bool|static
    {
        if (is_null($value)) {
            return $this->isREST;
        }
        $this->isREST = $value;
        return $this;
    }

    public function jwtToken(string $value = null): string|static
    {
        if (is_null($value)) {
            return $this->jwtToken;
        }
        $this->jwtToken = $value;
        return $this;
    }

    public function addURIParam(string $key, string $value): void
    {
        $this->uriParams[$key] = $value;
    }

    public function existURIParam(string $key): bool
    {
        return isset($this->uriParams[$key]);
    }

    public function getURIParam(string $key): mixed
    {
        return $this->uriParams[$key];
    }

    public function addPostParam(string $key, string $value): void
    {
        $this->postParams[$key] = $value;
    }

    public function existPostParam(string $key): bool
    {
        return isset($this->postParams[$key]);
    }

    public function getPostParam(string $key): mixed
    {
        return $this->postParams[$key];
    }
}