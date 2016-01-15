<?php

use Phale\Endpoint;
use Phunit\Tests;
use Phunit\Assert;
use Phale\Module;
use Phale\Factory;


class ModuleTests extends Tests {

    const VALID_MODULE_NAME = 'VALID_MODULE_NAME';
    const VALID_SUB_MODULE_NAME = 'VALID_SUB_MODULE_NAME';
    const VALID_SUB_MODULE_PATH = 'VALID_SUB_MODULE_PATH';
    const VALID_FACTORY_NAME = 'VALID_FACTORY_NAME';
    const VALID_ENDPOINT_PATH = 'VALID_ENDPOINT_PATH';
    public $VALID_FACTORY_DEPENDENCIES = [];
    public $VALID_ENDPOINT_DEPENDENCIES = [];
    public $VALID_FACTORY_FACTORY = null;
    public $VALID_ENDPOINT_HANDLER = null;

    public function __construct() {
        $this->VALID_FACTORY_FACTORY = function(){};
        $this->VALID_ENDPOINT_HANDLER = function(){};
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

    public function Constructor_ValidName_NewModule() {
        // arrange

        // act
        $module = new Module(self::VALID_MODULE_NAME);

        // assert
        Assert::areEqual($module->name, self::VALID_MODULE_NAME);
        Assert::areSame($module->modules, []);
        Assert::areSame($module->factories, []);
        Assert::areSame($module->endpoints, [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [],
        ]);
    }

    public function module_ValidPathAndSubModule_RegisterSubModuleAndInherit() {
        // arrange
        $module = new Module(self::VALID_MODULE_NAME);
        $subModule = new Module(self::VALID_SUB_MODULE_NAME);
        $factory = new Factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);
        $subModule->factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);
        $subModule->get(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $subModule->post(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $subModule->put(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $subModule->delete(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $expectedEndpoint = new Endpoint(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);

        // act
        $module->module(self::VALID_SUB_MODULE_PATH, $subModule);

        // assert
        Assert::areSame($module->modules, [
            self::VALID_SUB_MODULE_PATH => $subModule,
        ]);
        Assert::areSame($module->factories, [
            self::VALID_FACTORY_NAME => $factory,
        ]);
        Assert::areSame($module->endpoints, [
            'GET' => [self::VALID_SUB_MODULE_PATH . self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'POST' => [self::VALID_SUB_MODULE_PATH . self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'PUT' => [self::VALID_SUB_MODULE_PATH . self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'DELETE' => [self::VALID_SUB_MODULE_PATH . self::VALID_ENDPOINT_PATH => $expectedEndpoint],
        ]);
    }

    public function factory_ValidFactory_RegisterFactory() {
        // arrange
        $expectedFactory = new Factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);
        $module = new Module(self::VALID_MODULE_NAME);

        // act
        $module->factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);

        // assert
        Assert::areSame($module->factories, [self::VALID_FACTORY_NAME => $expectedFactory]);
    }

    public function get_ValidHandler_RegisterEndpoint() {
        // arrange
        $expectedEndpoint = new Endpoint(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $module = new Module(self::VALID_MODULE_NAME);

        // act
        $module->get(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);

        // assert
        Assert::areSame($module->endpoints, [
            'GET' => [self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [],
        ]);
    }

    public function post_ValidHandler_RegisterEndpoint() {
        // arrange
        $expectedEndpoint = new Endpoint(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $module = new Module(self::VALID_MODULE_NAME);

        // act
        $module->post(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);

        // assert
        Assert::areSame($module->endpoints, [
            'GET' => [],
            'POST' => [self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'PUT' => [],
            'DELETE' => [],
        ]);
    }

    public function put_ValidHandler_RegisterEndpoint() {
        // arrange
        $expectedEndpoint = new Endpoint(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $module = new Module(self::VALID_MODULE_NAME);

        // act
        $module->put(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);

        // assert
        Assert::areSame($module->endpoints, [
            'GET' => [],
            'POST' => [],
            'PUT' => [self::VALID_ENDPOINT_PATH => $expectedEndpoint],
            'DELETE' => [],
        ]);
    }

    public function delete_ValidHandler_RegisterEndpoint() {
        // arrange
        $expectedEndpoint = new Endpoint(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);
        $module = new Module(self::VALID_MODULE_NAME);

        // act
        $module->delete(self::VALID_ENDPOINT_PATH, $this->VALID_ENDPOINT_DEPENDENCIES, $this->VALID_ENDPOINT_HANDLER);

        // assert
        Assert::areSame($module->endpoints, [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [self::VALID_ENDPOINT_PATH => $expectedEndpoint],
        ]);
    }

}
