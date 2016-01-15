<?php

namespace Phale;


class Request {

    /**
     * @var string
     */
    public $protocol;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $path;

    /**
     * Request constructor.
     */
    public function __construct() {
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->path = $this->getPath();
    }

    /**
     * Get the path from string.
     * @return string
     */
    private function getPath() {
        $parts = explode('?', $_SERVER['REQUEST_URI']);
        return $parts[0];
    }

}
