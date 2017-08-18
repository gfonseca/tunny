<?php
use \Tunny\Loader\JsonLoader;
use AspectMock\Test as Test;
use Codeception\Util\Stub;

class JsonLoaderTest extends \Codeception\TestCase\Test
{
    protected $tester;
    private $filepath = "/tmp/JsonLoaderTest.json";
    private $filepath2 = "/tmp/JsonLoaderTest2.json";

    protected function _before()
    {
        $this->json = '{
            "system": "Fedora",
            "cpu": "Intel",
            "memory": "8159820"
        }';

        $this->json2 = '{
            "HD": "100000"
        }';

        $this->wrong = '{
            "system": "Fedora",
            "cpu": "Intel
            "memory": "8159820"
        }';
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
            $this->json,
            $this->json2
        );
        $j= new JsonLoader(array($this->filepath, $this->filepath2));
        $conf = $j->getConf();
        $this->assertEquals(
            $conf["system"],
            "Fedora"
        );
        $this->assertEquals(
            $conf["HD"],
            "100000"
        );

        #Assert worng json raise an exception
        $this->mockMultiple(
            $this->json,
            $this->wrong
        );

        $invalid_json_checker = false;
        try{
            $j= new JsonLoader(array($this->filepath, $this->filepath2));
        } catch (Exception $e){
            $invalid_json_checker = true;
        }
        $this->assertTrue($invalid_json_checker);
    }

    public function testConstruct()
    {
        #Assert that invalid file raise exception
        $invalid_file_checker = false;
        try {
            new JsonLoader("/tmp/fileThatNotExists.ext");
        } catch (Exception $e) {
            $invalid_file_checker = true;
        }
        $this->assertTrue(
            $invalid_file_checker,
            "Invalid file path must raise an exception."
        );

        #Assert that invalid Json raise exception
        $invalid_json_checker = false;
        try {
            $this->mockFile($this->wrong);
        } catch (Exception $e) {
            $invalid_json_checker = true;
        }
        $this->assertTrue(
            $invalid_json_checker,
            "Invalid json must raise an exception."
        );

        #Assert that load multiple files
        $invalid_file_checker = false;
        try {
            new JsonLoader("/tmp/fileThatNotExists.ext");
        } catch (Exception $e) {
            $invalid_file_checker = true;
        }
        $this->assertTrue(
            $invalid_file_checker,
            "Invalid file path must raise an exception."
        );
    }

    public function testGetConf()
    {
        #Assert values loaded correctly
        $tested = $this->mockFile($this->json);
        $conf = $tested->getConf();
        $this->assertTrue($conf["system"] == "Fedora");
    }

    private function mockMultiple($json, $json2)
    {
        file_put_contents($this->filepath, $json);
        file_put_contents($this->filepath2, $json2);
    }

    private function mockFile($json)
    {
        file_put_contents($this->filepath, $json);
        return new JsonLoader($this->filepath);
    }
}
