<?php

namespace Phale;


class Request {

    /**
     * @param array $server
     * @return Request
     */
    static public function fromHttp(array $server) {
        $protocol = $server['SERVER_PROTOCOL'];
        $method = strtoupper($server['REQUEST_METHOD']);
        $parts = explode('?', $server['REQUEST_URI']);
        $path = $parts[0];
        return new self($protocol, $method, $path);
    }

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
     * @param string $protocol
     * @param string $method
     * @param string $path
     */
    public function __construct($protocol, $method, $path) {
        $this->protocol = $protocol;
        $this->method = $method;
        $this->path = $path;
    }

}
