<?php
use \Tunny\Loader\PHPArrayLoader;
use AspectMock\Test as Test;
use Codeception\Util\Stub;

class PHPArrayLoaderTest extends \Codeception\TestCase\Test
{
    protected $tester;
    private $filepath = "/tmp/PHPArrayLoaderTest.php";
    private $filepath2 = "/tmp/PHPArrayLoaderTest2.php";

    protected function _before()
    {
        $this->php = '<?php
        return array(
            "system" => array(
                "os" => "Fedora",
                "cpu" => "Intel",
                "memory" => "8159820"
            )
        );';

        $this->php2 = '<?php
        return array(
            "system" =>array(
                "hd" => "100000"
            )
        );';

        $this->wrong = '<?php
        return array(
            "system" => array(
                "hd" => "100000"
        );';
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
        $this->mockMultiple($this->php, $this->php2);
        $php_conf = new PHPArrayLoader(array($this->filepath, $this->filepath2));
        $conf = $php_conf->getConf();
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
            "PHPLoader must raise an exception in case of wrong file"
        );
    }

    public function testGetConf()
    {
        $php_loader = $this->mockFile($this->php);
        $conf = $php_loader->getConf();
        $this->assertEquals($conf['system']['os'], "Fedora");
        $this->assertEquals($conf['system']['cpu'], "Intel");
    }

    private function mockMultiple($php, $php2)
    {
        file_put_contents($this->filepath, $php);
        file_put_contents($this->filepath2, $php2);
    }

    private function mockFile($php)
    {
        file_put_contents($this->filepath, $php);
        return new PHPArrayLoader($this->filepath);
    }
}
