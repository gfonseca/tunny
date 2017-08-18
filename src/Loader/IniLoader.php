<?php
namespace Tunny\Loader;
use Codeception\Util\Debug;

class IniLoader extends AbstractLoader
{
    protected function parse($content) {
        $out = @parse_ini_string($content, true);

        if($out === false) {
            throw new LoaderException("Failed to parse {$content}.");
        }

        return $out;
    }
}
