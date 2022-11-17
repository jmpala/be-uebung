<?php

namespace Framework\Router;

use Framework\Contracts\Controller;
use Framework\Contracts\Runnable;
use Framework\Http\Request;
use http\Exception;

class Router
{
    /**
     * @var array [string 'method:uri' => class|closure runner implements Runnable, ...]
     */
    protected array $runners = [];

    public function __construct(){}

    public function register(string $methodUri, Controller|\Closure $runner): void
    {
        $this->runners[$methodUri] = $runner;
    }

    public function isRegistered(string $methodUri): bool
    {
        return isset($this->runners[$methodUri]);
    }

    public function resolve(Request $request): string {
        $methodUri = $this->buildMethodUriString($request->method(), $request->uri());

        if (!isset($this->runners[$methodUri])) {
            throw new \InvalidArgumentException('the method:uri given is not registered');
        }

        $mask = $this->retrieveMask($methodUri);
        if ($this->maskHasParameters($mask)) {
            [$key, $value] = $this->extractParameters($methodUri, $mask);
            $request->addParam($key, $value);
        }

        if ($this->runners[$methodUri] instanceof Controller) {
            return $this->runners[$methodUri]->handle($request);
        }

        if ($this->runners[$methodUri] instanceof \Closure) {
            return $this->runners[$methodUri]($request);
        }

    }

    // TODO: refactor the two places where is used in this class, prone to errors
    private function maskHasParameters(string $mask): bool
    {
        return 1 === preg_match('#{([?]?)([^}]*)}#', $mask, $matchedKey);
    }

    public function extractParameters(string $uri, string $mask): array
    {
        preg_match('#{([?]?)([^}]*)}#', $mask, $matchedKey);
        $isOptional = !empty($matchedKey[1]);
        $matchMaskKey = "#{([" . $matchedKey[1] . $matchedKey[2] . "^}]*)}#";

        $matchUriParam = preg_replace($matchMaskKey,'([^/]*)',$mask);
        $matchUriParam = "#{$matchUriParam}#";

        preg_match($matchUriParam, $uri, $matchedValue);

        $key = $matchedKey[2];
        $value = $matchedValue[1];
        return [$key, $value];
    }

    public function buildMethodUriString(string $method, string $uri): string
    {
        return $method.':'.$uri;
    }

    public function retrieveMask(string $methodUri): string|\InvalidArgumentException
    {
        foreach ($this->runners as $mask => $runner) {
            if ($this->match($methodUri, $mask)) {
                return $mask;
            }
        }
        throw new \InvalidArgumentException('the provided method:uri is not registered');
    }

    private function match(string $methodUri, string $mask): bool
    {
        if ($this->maskHasParameters($mask)) {
            [$key, $value] = $this->extractParameters($methodUri, $mask);
            $mask = $this->maskToUriMethod($mask, $key, $value);
        }
        return $methodUri === $mask;
    }

    private function maskToUriMethod(string $mask, string $key, string $value): string
    {
        return preg_replace('#{([^}]*)}#', $value, $mask);
    }

    // TODO: delete?
    private function maskIsOptional(string $mask): bool
    {
        preg_match('#{([?]?)([^}]*)}#', $mask, $matchedKey);
        return !empty($matchedKey[1]);
    }

    // TODO: delete?
    private function maskToRegex(string $mask): string
    {
        preg_match('#{([?]?)([^}]*)}#', $mask, $matchedKey);
        $isOptional = !empty($matchedKey[1]);
        $matchMaskKey = "#{([" . $matchedKey[1] . $matchedKey[2] . "^}]*)}#";
        $matchUriParam = preg_replace($matchMaskKey,'([^/]*)',$mask);
        return "#{$matchUriParam}#";
    }


}