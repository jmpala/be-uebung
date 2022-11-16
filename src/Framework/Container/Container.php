<?php

namespace Framework\Container;

class Container
{
    private static ?Container $instance = null;

    /**
     * @var array [string name, object::class]
     */
    private array $factories = [];

    /**
     * @var array [string name, instance]
     */
    private array $createdInstances= [];

    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
            return static::$instance;
        }
        return static::$instance;
    }

    public function register(string $factoryName, string $class): static
    {
        $this->factories[$factoryName] = $class;
        return $this;
    }

    public function hasFactory(string $factoryName): bool
    {
        return isset($this->factories[$factoryName]);
    }

    public function fetch(string $registeredInstance): mixed
    {
        if (!isset($this->createdInstances[$registeredInstance])) {
            if (!isset($this->factories[$registeredInstance])) {
                throw new \InvalidArgumentException('requested instance was not registered');
            }

            $this->createdInstances[$registeredInstance] = new $this->factories[$registeredInstance];
            return $this->createdInstances[$registeredInstance];
        }
        return $this->createdInstances[$registeredInstance];
    }

}