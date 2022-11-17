<?php

if (!function_exists('container')) {
    function container(): \Framework\Container\Container
    {
        return \Framework\Container\Container::getInstance();
    }
}