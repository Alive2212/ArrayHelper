<?php

namespace Alive2212\ArrayHelperTest\Unit;

use Alive2212\ArrayHelper\ArrayHelper;
use Alive2212\LaravelSmartMeta\Cache;
use Alive2212\LaravelSmartMeta\SmartMeta;
use Alive2212\LaravelSmartMeta\SmartMetaClass;
use Alive2212\LaravelSmartResponse\ResponseModel;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    /**
     * @var string
     */
    private $PACKAGE_NAME = "ArrayHelper";

    /**
     * @var array
     */
    private $PACKAGE_CLASSES = [
        "ArrayHelper",
    ];

    /**
     * @var string
     */
    private $VENDOR = 'Alive2212';

    protected $app;

    public function __construct()
    {
        parent::__construct();
        $this->createApplication();
    }

    public function createApplication()
    {
        $app = new Container();
        $app->bind('app', 'Illuminate\Container\Container');

        foreach ($this->PACKAGE_CLASSES as $PACKAGE_CLASS) {
            $app->bind($PACKAGE_CLASS, $this->VENDOR.'\\'.$this->PACKAGE_NAME.'\\'.$PACKAGE_CLASS);
        }

        $app->bind('Cache', 'Illuminate\Support\Facades\Cache');

        $this->app = $app;
        Facade::setFacadeApplication($app);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // create String Helper
        foreach ($this->PACKAGE_CLASSES as $PACKAGE_CLASS) {
            ${$PACKAGE_CLASS} = $this->app->make($PACKAGE_CLASS);
        }

        $arrayHelper = new ArrayHelper();
        $testArray = [
            'key1' => 'value1',
            'key2' => [
                'key21' => 'value21',
            ]
        ];

        $this->assertTrue($arrayHelper->isMapArray($testArray));

        $this->assertTrue($arrayHelper->getDeep($testArray,'key2.key21') == 'value21');

        $this->assertTrue(is_array($arrayHelper->serializeArray($testArray)->getValue()));

        $this->assertTrue(true);
    }
}
