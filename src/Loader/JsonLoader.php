<?php
namespace Tunny\Loader;

class JsonLoader extends AbstractLoader
{
    protected function parse($content) {
        $data = json_decode($content, true);

        if($data === null) {
            throw new \Exception("Invalid json content");
        }

        return $data;
    }
}
