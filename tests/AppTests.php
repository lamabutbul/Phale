<?php

use Phunit\Tests;
use Phunit\Assert;
use Phale\Module;
use Phale\App;
use Phale\Request;
use Phale\Response;


class AppTests extends Tests {

    const VALID_APP_NAME = 'VALID_APP_NAME';
    const VALID_ENDPOINT_PATH = '/valid/:endpoint';
    public $VALID_ENDPOINT_DEPENDENCIES = [];
    public $VALID_ENDPOINT_HANDLER = null;

    public $VALID_ENDPOINT_WITH_DEPENDENCIES_DEPENDENCIES = ['VALID_DEPENDENCY_NAME'];
    public $VALID_ENDPOINT_WITH_DEPENDENCIES_HANDLER = null;

    const VALID_DEPENDENCY_NAME = 'VALID_DEPENDENCY_NAME';
    public $VALID_DEPENDENCY_DEPENDENCIES = [];
    public $VALID_DEPENDENCY_FACTORY = null;
    const VALID_DEPENDENCY = 'VALID_DEPENDENCY';

    public function __construct() {
        $this->VALID_ENDPOINT_HANDLER = function(Request $request, Response $response){};
        $this->VALID_ENDPOINT_WITH_DEPENDENCIES_HANDLER = function(Request $request, Response $response, $dependency){};
        $this->VALID_DEPENDENCY_FACTORY = function(){return self::VALID_DEPENDENCY;};
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function Constructor_InvalidName_ThrowsException() {
        // arrange

        // act
        new Module(null);

        // assert
    }

    public function Constructor_ValidName_NewApp() {
        // arrange

        // act
        $app = new App(self::VALID_APP_NAME);

        // assert
        Assert::areEqual($app->name, self::VALID_APP_NAME);
//        Assert::areEqual(get_class($app->request), get_class(new \Phale\Request()));
    }

    public function preparePathRegexp_RootPath_ReturnsRegExp() {
        // arrange
        $app = new App(self::VALID_APP_NAME);

        // act
        $regexp = $app->preparePathRegexp('/');

        // assert
        Assert::areEqual($regexp, "/^\\/$/");
    }

    public function preparePathRegexp_SinglePath_ReturnsRegExp() {
        // arrange
        $app = new App(self::VALID_APP_NAME);

        // act
        $regexp = $app->preparePathRegexp('/path');

        // assert
        Assert::areEqual($regexp, "/^\\/path$/");
    }

    public function preparePathRegexp_MultiPath_ReturnsRegExp() {
        // arrange
        $app = new App(self::VALID_APP_NAME);

        // act
        $regexp = $app->preparePathRegexp('/multi/path');

        // assert
        Assert::areEqual($regexp, "/^\\/multi\\/path$/");
    }

    public function preparePathRegexp_PathWithNamedParameter_ReturnsRegExp() {
        // arrange
        $app = new App(self::VALID_APP_NAME);

        // act
        $regexp = $app->preparePathRegexp('/multi/path/:arg/path');

        // assert
        Assert::areEqual($regexp, "/^\\/multi\\/path\\/(?P<arg>[^\\/]+)\\/path$/");
    }

    public function run_ValidPath_ReturnsResponse() {
        // arrange
        $app = new App(self::VALID_APP_NAME);
        $app->get(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $request = new Request('HTTP/1.1', 'GET', '/valid/endpoint');
        $response = new Response('HTTP/1.1');

        // act
        $app->run($request, $response);

        // assert

    }

    public function run_ValidPathWithDependencies_ReturnsResponse() {
        // arrange
        $app = new App(self::VALID_APP_NAME);
        $app->factory(self::VALID_DEPENDENCY_NAME, $this->VALID_DEPENDENCY_DEPENDENCIES, $this->VALID_DEPENDENCY_FACTORY);
        $app->get(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_WITH_DEPENDENCIES_DEPENDENCIES, $this->VALID_ENDPOINT_WITH_DEPENDENCIES_HANDLER);
        $request = new Request('HTTP/1.1', 'GET', '/valid/endpoint');
        $response = new Response('HTTP/1.1');

        // act
        $app->run($request, $response);

        // assert

    }

}
