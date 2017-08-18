<?php
namespace Tunny\Loader;

use Symfony\Component\Yaml\Yaml;

class YAMLLoader extends AbstractLoader
{
    protected function parse($content) {
        $value = Yaml::parse($content);
        return $value;
    }
}
