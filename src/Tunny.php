<?php

namespace Tunny;

abstract class Tunny {

    const TUNNY_EXT_JSON = "json";
    const TUNNY_EXT_YAML = "yml";
    const TUNNY_EXT_INI = "ini";
    const TUNNY_EXT_PHP = "php";

    public static function array_overlay($a1, $a2)
    {
        foreach($a2 as $k => $v) {
            if(!array_key_exists($k, $a1)) {
                $a1[$k] = $v;
                continue;
            }

            if(is_array($a1[$k]) && is_array($v)) {
                $a1[$k] = self::array_overlay($a1[$k], $v);
            } else {
                $a1[$k] = $v;
            }
        }
        return $a1;
    }

    public static function parseFileExtension($file)
    {
        $loader_map = array(
            self::TUNNY_EXT_JSON => "\\Tunny\\Loader\\JsonLoader",
            self::TUNNY_EXT_YAML => "\\Tunny\\Loader\\YAMLLoader",
            self::TUNNY_EXT_PHP => "\\Tunny\\Loader\\PHPArrayLoader",
            self::TUNNY_EXT_INI => "\\Tunny\\Loader\\IniLoader",
        );

        $split_file_name = explode(".", $file);
        $ext = end($split_file_name);

        if(isset($loader_map[$ext])) {
            return new $loader_map[$ext]($file);
        }

        throw new Loader\LoaderException("Extension .{$ext} not suported in file {$file}");
    }
}
