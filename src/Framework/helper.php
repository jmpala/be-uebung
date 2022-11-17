<?php

if (!function_exists('container')) {
    function container(string $alias = null): mixed
    {
        if (is_null($alias)) {
            return \Framework\Container\Container::getInstance();
        }
        return \Framework\Container\Container::getInstance()->fetch($alias);
    }
}