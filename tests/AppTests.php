<?php

use Phunit\Tests;
use Phunit\Assert;
use Phale\Module;
use Phale\App;


class AppTests extends Tests {

    const VALID_APP_NAME = 'VALID_APP_NAME';

    public function __construct() {

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

}
