<?php
namespace Tunny\Loader;

use Tunny\Tunny;

abstract class AbstractLoader implements LoaderInterface
{
    private $file;
    private $value_tree;
    private $conf;
    protected $content;

    public function __construct($file)
    {
        $this->file = $file;
        $this->conf = null;
        $this->bootstrap($file);
    }

    public function getConf()
    {
        return $this->conf;
    }

    protected function parse($content)
    {
        return $content;
    }

    protected function readFile($file)
    {
        $this->checkFile($file);
        return file_get_contents($file);
    }

    protected function checkFile($file)
    {
        if(!is_file($file)) {
            throw new \InvalidArgumentException("Invalid file path {$file}.");
        }
        return true;
    }

    private function bootstrap($file)
    {
        if (!is_array($file)) {
            $file = array($file);
        }

        $this->loadMultipleFiles($file);
    }

    private function loadMultipleFiles(array $files)
    {
        $out = array();
        foreach ($files as $k => $f) {
            $file_content = $this->readFile($f);
            $out = Tunny::array_overlay($out, $this->parse($file_content));
        }

        $this->conf = $out;
    }
}
