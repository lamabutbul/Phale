<?php

namespace Phale;


class App extends Module {

    /**
     * App constructor.
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct($name);
    }

    /**
     * Run the application.
     * @param Request $request
     */
    public function run(Request $request) {
//        $handler = $this->getHandler();
    }

    /**
     * Prepare a regular expression from the path pattern.
     * @param string $path
     * @return string
     */
    public function preparePathRegexp($path) {
        $parts = explode('/', $path);
        foreach ($parts as &$part) {
            if (strpos($part, ':') === 0) {
                $part = sprintf("(?P<%s>[^\\/]+)", substr($part, 1));
            }
        }
        return sprintf('/^%s$/', implode("\\/", $parts));
    }

}
