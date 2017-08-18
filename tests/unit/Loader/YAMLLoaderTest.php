<?php
use \Tunny\Loader\YAMLLoader;
use AspectMock\Test as Test;
use Codeception\Util\Stub;

class YAMLLoaderTest extends \Codeception\TestCase\Test
{
    protected $tester;
    private $filepath = "/tmp/YAMLLoaderTest.yaml";
    private $filepath2 = "/tmp/YAMLLoaderTest2.yaml";

    protected function _before()
    {
        $this->yaml = 'system:
    os: Fedora
    cpu: Intel
    memory: 8159820';
        $this->yaml2 = 'system:
    hd: 100000';
        $this->wrong = '{"system00000"}';
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
        $this->mockMultiple($this->yaml, $this->yaml2);
        $yaml_conf = new YAMLLoader(array($this->filepath, $this->filepath2));
        $conf = $yaml_conf->getConf();
        $this->assertEquals($conf['system']['os'], "Fedora");
        $this->assertEquals($conf['system']['hd'], "100000");
    }

    public function testConstruct()
    {
        $check_raise_exception = false;
        try{
            $this->mockFile($this->wrong);
        }catch(Exception $e){
            $check_raise_exception = true;
        }
        $this->assertTrue(
            $check_raise_exception,
            "YAMLLoader must raise an exception incase of wrong file"
        );
    }

    public function testGetConf()
    {
        $yaml_loader = $this->mockFile($this->yaml);
        $conf = $yaml_loader->getConf();
        $this->assertEquals($conf['system']['os'], "Fedora");
        $this->assertEquals($conf['system']['cpu'], "Intel");
    }

    private function mockMultiple($yaml, $yaml2)
    {
        file_put_contents($this->filepath, $yaml);
        file_put_contents($this->filepath2, $yaml2);
    }

    private function mockFile($yaml)
    {
        file_put_contents($this->filepath, $yaml);
        return new YAMLLoader($this->filepath);
    }
}
