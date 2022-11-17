<?php

namespace Framework\Http;

class Request
{
    protected array $uriParams = [];

    protected string $method;
    protected string $uri;

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

    public function addParam(string $key, string $value): void
    {
        $this->uriParams[$key] = $value;
    }

    public function existParam(string $key): bool
    {
        return isset($this->uriParams[$key]);
    }
}