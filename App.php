<?php

namespace Phale;


class App extends Module {

    /**
     * @var string
     */
    public $basePath;

    /**
     * @var array
     */
    public $dependencies = [];

    /**
     * App constructor.
     * @param string $name
     * @param string $basePath
     */
    public function __construct($name, $basePath = '') {
        parent::__construct($name);
        $this->basePath = $basePath;
    }

    /**
     * Run the application.
     * @param Request $request
     * @param Response $response
     */
    public function run(Request $request, Response $response) {
        if ($this->basePath && strpos($request->path, $this->basePath) === 0) {
            $request->path = substr($request->path, strlen($this->basePath));
        }
        $endpoint = null;
        $args = [];
        foreach ($this->endpoints[$request->method] as $path => $possible_endpoint) {
            $regexp = $this->preparePathRegexp($path);
            if (preg_match($regexp, $request->path, $results)) {
                $endpoint = $possible_endpoint;
                foreach ($results as $key => $result) {
                    if (!is_int($key)) {
                        $args[] = $result;
                    }
                }
            }
        }
        $dependencies = $this->getDependencies($endpoint->dependencies);
        if ($endpoint) {
            call_user_func_array($endpoint->handler, array_merge([$request, $response], $args, $dependencies));
        }
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

    /**
     * @param string[] $names
     * @return array
     */
    public function getDependencies(array $names) {
        $dependencies = [];
        foreach ($names as $name) {
            if (!isset($this->dependencies[$name])) {
                $factory = $this->factories[$name];
                $this->dependencies[$name] = call_user_func_array($factory->factory, $this->getDependencies($factory->dependencies));
            }
            $dependencies[] = $this->dependencies[$name];
        }
        return $dependencies;
    }

}
