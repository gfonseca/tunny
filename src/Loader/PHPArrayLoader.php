<?php
namespace Tunny\Loader;

class PHPArrayLoader extends AbstractLoader
{
    protected function readFile($file)
    {
        $this->checkFile($file);
        if(!$this->runLint($file)) {
            throw new \Exception("Faile to parse {$file}.");
        }
        return require $file;
    }

    private function runLint($file)
    {
        $output = shell_exec("php -d error_reporting=0 -l {$file}");
        return !$this->checkForErrors($output);
    }

    private function checkForErrors($output)
    {
        $regex_return = array();
        preg_match_all("/(?P<error>^Errors parsing)/", $output, $regex_return);
        return (bool)$regex_return["error"];
    }
}
