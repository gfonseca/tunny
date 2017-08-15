<?php
namespace Atune\Loader;

abstract class AbstractLoader
{
    private $file;
    private $content;
    private $value_tree;

    public function __construct($file)
    {
        if (is_array($file)) {
            $this->loadMultipleFiles($file);
        } else {
            $this->loadSingleFile($file);
        }
    }

    private function loadSingleFile(string $file)
    {

    }

    private function loadMultipleFiles(array $files)
    {
        foreach ($files as $k => $f) {
            $ext = $this->extractExtension();
            $this->content[] = $this->readFile($f);
        }
    }

    private function checkFile($file)
    {
        if(!is_file($file)) {
            return false;
        }
        return true;
    }

    private function readFile()
    {

    }
}
