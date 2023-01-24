<?php

declare(strict_types=1);

namespace Framework\Http;

class Response
{
    private ?string $content = null;
    private array $headers = [];

    private int $statusCode;

    public function content(string $content = null): string|static
    {
        if (is_null($content)) {
            return $this->content;
        }
        $this->content = $content;
        return $this;
    }

    public function addHeader(string $key, string $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function isHeaderSet(string $key): bool
    {
        return isset($this->headers[$key]);
    }

    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

    public function removeHeader(string $key): static
    {
        unset($this->headers[$key]);
        return $this;
    }

    public function statusCode(int $code = null): int|static
    {
        if (is_null($code)) {
            return $this->statusCode;
        }
        $this->statusCode = $code;
        return $this;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function statusCodeMessage(): string
    {
        return StatusCode::MESSAGES[$this->statusCode];
    }
}