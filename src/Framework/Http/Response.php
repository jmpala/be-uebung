<?php

namespace Framework\Http;

class Response
{
    private ?string $content = null;

    public function content(string $content = null): string|static
    {
        if (is_null($content)) {
            return $this->content;
        }
        $this->content = $content;
        return $this;
    }
}