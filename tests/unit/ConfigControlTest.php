<?php
namespace ConfigTest;

use AlThread\Config\ConfigControl;
use AspectMock\Test as Test;
use Codeception\Util\Stub;

class ConfigControlTest extends \Codeception\TestCase\Test
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    protected function _before()
    {
        //exec("touch /tmp/loader_test.txt");
    }

    protected function _after()
    {
        //exec("rm /tmp/loader_test.txt");
        //Test::clean();
    }

    public function testGet()
    {
        $file = $this->stubConfFile();
        $config_control = new ConfigControl($file);

        $this->assertEquals(20, $config_control->max_threads);
    }

    public function testUpdate()
    {
        $file = $this->stubConfFile();

        $config_control = new ConfigControl($file);
        $this->assertEquals(20, $config_control->max_threads);

        $config_control->checkForFileChange();

        $this->assertEquals(20, $config_control->max_threads);

        $config_control->checkForFileChange();

        $this->assertEquals(20, $config_control->max_threads);
    }

    protected function stubLoaderUpdate()
    {
        $json = '{
            "threads" : 40,
            "connections" : 60,
            "min_load" : 2
        }';

        return Test::double(
            "AlThread\\Config\\ConfigLoader",
            ["loadConfig" => json_decode($json)]
        );
    }

    protected function stubLoader()
    {
        $json = '{
            "threads" : 20,
            "connections" : 80,
            "max_load" : 6,
            "subObj" : {
                "subAttr" : "value"
            }
        }';

        return Test::double(
            "AlThread\\Config\\ConfigLoader",
            ["loadConfig" => json_decode($json)]
        );
    }

    protected function stubConfFile()
    {
        return Stub::construct(
            "\\SplFileObject",
            array("filename" => __DIR__ . "/../_resources/job_fact.json"),
            array("getMtime" => Stub::consecutive(
                1441324238,
                1441324238,
                1441324239
            ))
        );
    }
}
