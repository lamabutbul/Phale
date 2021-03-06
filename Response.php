<?php

namespace Phale;


class Response {

    /**
     * @return Response
     */
    static public function fromHttp() {
        return new self($_SERVER['SERVER_PROTOCOL']);
    }

    /**
     * @var string
     */
    public $protocol;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string[]
     */
    public $headers = [];

    /**
     * @var string
     */
    public $body;

    /**
     * Response constructor.
     * @param string $protocol
     */
    public function __construct($protocol) {
        $this->protocol = $protocol;
    }

    /**
     * Set a JSON response body.
     * @param mixed $object
     * @return Response
     */
    public function json($object) {
        $this->body = json_encode($object);
        $this->headers['Content-Type'] = 'application/json';
        return $this;
    }

    /**
     * Respond to client and quit the script.
     */
    public function respond() {
        switch ($this->status) {
            case 200:
                break;
            case 404:
                header(sprintf('%s 404 Page Not Found', $this->protocol));
                break;
        }
        foreach ($this->headers as $name => $header) {
            header(sprintf('%s: %s', $name, $header));
        }
        print $this->body;
        exit;
    }

}
