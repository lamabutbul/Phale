<?php

namespace Phale;


class Endpoint {

    /**
     * @var string
     */
    public $path;

    /**
     * @var string[]
     */
    public $dependencies;

    /**
     * @var callable
     */
    public $handler;

    /**
     * @param string $path
     * @param string[] $dependencies
     * @param callable $handler
     */
    public function __construct($path, array $dependencies, callable $handler) {
        $this->path = $path;
        $this->dependencies = $dependencies;
        $this->handler = $handler;
    }

}
