<?php

use Punit\Tests;
use Punit\Assert;
use Phale\Module;
use Phale\Factory;


class ModuleTests extends Tests {

    const VALID_MODULE_NAME = 'VALID_MODULE_NAME';
    const VALID_SUB_MODULE_NAME = 'VALID_SUB_MODULE_NAME';
    const VALID_SUB_MODULE_PATH = 'VALID_SUB_MODULE_PATH';
    const VALID_FACTORY_NAME = 'VALID_FACTORY_NAME';
    public $VALID_FACTORY_DEPENDENCIES = [];
    public $VALID_FACTORY_FACTORY = null;

    public function __construct() {
        $this->VALID_FACTORY_FACTORY = function(){};
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

    public function module_ValidPathAndSubModule_RegisterSubModule() {
        // arrange
        $module = new Module(self::VALID_MODULE_NAME);
        $subModule = new Module(self::VALID_SUB_MODULE_NAME);
        $factory = new Factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);
        $subModule->factory(self::VALID_FACTORY_NAME, $this->VALID_FACTORY_DEPENDENCIES, $this->VALID_FACTORY_FACTORY);

        // act
        $module->module(self::VALID_SUB_MODULE_PATH, $subModule);

        // assert
        Assert::areSame($module->modules, [
            self::VALID_SUB_MODULE_PATH => $subModule,
        ]);
        Assert::areSame($module->factories, [
            self::VALID_FACTORY_NAME => $factory,
        ]);
    }

}

