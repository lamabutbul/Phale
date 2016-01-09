<?php

namespace Phale;


class Factory {

    /**
     * @var string
     */
    public $name;

    /**
     * @var string[]
     */
    public $dependencies;

    /**
     * @var callable
     */
    public $factory;

    /**
     * @param string $name
     * @param string[] $dependencies
     * @param callable $factory
     */
    public function __construct($name, array $dependencies, callable $factory) {
        $this->name = $name;
        $this->dependencies = $dependencies;
        $this->factory = $factory;
    }

}
