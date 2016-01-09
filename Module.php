<?php

namespace Phale;


class Module {

    /**
     * @var string
     */
    public $name;

    /**
     * @var Module[]
     */
    public $modules = [];

    /**
     * @var Factory[]
     */
    public $factories = [];

    /**
     * @var Endpoint[][]
     */
    public $endpoints = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
    ];

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     */
    public function __construct($name) {
        if (!$name) {
            throw new \InvalidArgumentException(sprintf('Invalid module name %s.', $name));
        }
        $this->name = $name;
    }

    /**
     * Register a module.
     *
     * @param string $path
     * @param Module $module
     */
    public function module($path, Module $module) {
        $this->modules[$path] = $module;
        $this->factories = array_merge($this->factories, $module->factories);
    }

    /**
     * Register a dependency factory.
     *
     * @param string $name
     * @param string[] $dependencies
     * @param callable $factory
     */
    public function factory($name, array $dependencies, callable $factory) {
        $this->factories[$name] = new Factory($name, $dependencies, $factory);
    }

    /**
     * Register a GET request handler.
     *
     * @param string $path
     * @param string[] $dependencies
     * @param callable $handler
     */
    public function get($path, array $dependencies, callable $handler) {
        $this->endpoints['GET'][$path] = new Endpoint($path, $dependencies, $handler);
    }

    /**
     * Register a POST request handler.
     *
     * @param string $path
     * @param string[] $dependencies
     * @param callable $handler
     */
    public function post($path, array $dependencies, callable $handler) {
        $this->endpoints['POST'][$path] = new Endpoint($path, $dependencies, $handler);
    }

    /**
     * Register a PUT request handler.
     *
     * @param string $path
     * @param string[] $dependencies
     * @param callable $handler
     */
    public function put($path, array $dependencies, callable $handler) {
        $this->endpoints['PUT'][$path] = new Endpoint($path, $dependencies, $handler);
    }

    /**
     * Register a DELETE request handler.
     *
     * @param string $path
     * @param string[] $dependencies
     * @param callable $handler
     */
    public function delete($path, array $dependencies, callable $handler) {
        $this->endpoints['DELETE'][$path] = new Endpoint($path, $dependencies, $handler);
    }

}
