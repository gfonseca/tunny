<?php
use \Tunny\Config;
use \Tunny\Loader\AbstractLoader;
use \Codeception\Util\Stub;

class ConfigTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->conf = new Config($this->stubLoader());
    }

    protected function _after()
    {
    }

    protected function stubLoader()
    {
        $os_conf = array(
            "system" => array(
                "os" => "Fedora",
                "memory" => "8957844",
                "cpu" => "Intel"
            )
        );

        return  Stub::make(
            "\\Tunny\\Loader\\JsonLoader",
            array('getConf' => Stub::atLeastOnce(function() use ($os_conf) {
                    return $os_conf;
                })
            )
        );
    }

    public function testOffsetGet(){
        $this->assertTrue(isset($this->conf['system']));
    }

    public function testOffsetSet(){
        $gpu = "Nvidia";
        $this->conf["gpu"] = $gpu;
        $this->assertEquals($this->conf["gpu"], $gpu);
    }

    public function testOffsetUnset()
    {
        $this->assertTrue(isset($this->conf["system"]));
        unset($this->conf["system"]);
        $this->assertFalse(isset($this->conf["system"]));
    }

    public function testGetInvalidAttrThrowException()
    {
        $this->setExpectedException('\\Tunny\\ConfigException');
        $system_conf = $this->conf->get("cache_l2");
    }

    public function testGet()
    {
        $system_conf = $this->conf->get("system");
        $this->assertEquals(
            $system_conf['os'],
            "Fedora",
            "The values for ['system']['os'] doesen't match."
        );

        $this->assertEquals(
            $system_conf['memory'],
            "8957844",
            "The values for ['system']['os'] doesen't match."
        );
    }
}
