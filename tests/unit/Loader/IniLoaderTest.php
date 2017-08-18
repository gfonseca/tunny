<?php
use Tunny\Loader\IniLoader;
use Tunny\Loader\LoaderException;
use AspectMock\Test as Test;
use Codeception\Util\Stub;
use Codeception\Util\Debug;


class IniLoaderTest extends \Codeception\TestCase\Test
{
    protected $tester;
    private $filepath = "/tmp/IniLoaderTest.json";
    private $filepath2 = "/tmp/IniLoaderTest2.json";

    protected function _before()
    {
        $this->ini = '
            system=Fedora
            cpu=Intel
            memory=8159820';

        $this->ini2 = 'HD=100000';

        $this->wrong = '{[cpuIntel}';
    }

    protected function _after()
    {
        if (is_file($this->filepath)) {
            unlink($this->filepath);
        }

        if (is_file($this->filepath2)) {
            unlink($this->filepath2);
        }
    }
    public function testConstructMultiple()
    {
        #Assert load multiple files
        $this->mockMultiple(
            $this->ini,
            $this->ini2
        );
        $j= new IniLoader(array($this->filepath, $this->filepath2));
        $conf = $j->getConf();

        $this->assertEquals(
            $conf["system"],
            "Fedora"
        );
        $this->assertEquals(
            $conf["HD"],
            "100000"
        );

        #Assert worng ini raise an exception
        $this->mockMultiple(
            $this->ini,
            $this->wrong
        );

        $invalid_ini_checker = false;
        try{
            $i = new IniLoader(array($this->filepath, $this->filepath2));
        } catch (LoaderException $e){
            $invalid_ini_checker = true;
        }
        $this->assertTrue($invalid_ini_checker);
    }

    public function testConstruct()
    {
        #Assert that invalid Ini raise exception
        $invalid_ini_checker = false;
        try {
            $this->mockFile($this->wrong);
        } catch (LoaderException $e) {
            $invalid_ini_checker = true;
        }
        $this->assertTrue(
            $invalid_ini_checker,
            "Invalid ini must raise an exception."
        );
    }

    public function testGetConf()
    {
        #Assert values loaded correctly
        $tested = $this->mockFile($this->ini);
        $conf = $tested->getConf();
        $this->assertEquals($conf["system"], "Fedora");
        $this->assertEquals($conf["memory"], "8159820");
    }

    private function mockMultiple($ini, $ini2)
    {
        file_put_contents($this->filepath, $ini);
        file_put_contents($this->filepath2, $ini2);
    }

    private function mockFile($ini)
    {
        file_put_contents($this->filepath, $ini);
        return new IniLoader($this->filepath);
    }
}
