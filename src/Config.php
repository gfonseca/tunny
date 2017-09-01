<?php

namespace Tunny;

class Config implements \ArrayAccess{

    private $loader;
    private $conf;

    public function __construct($loaders)
    {
        $conf = $this->defaults();
        if(!is_array($loaders)) {
            $loaders = array($loaders);
        }
        foreach($loaders as $k => $l) {
            $conf = Tunny::array_overlay(
                $conf,
                $l->getConf()
            );
        }
        $this->conf = $conf;
    }

    public function __toString()
    {
        return print_r($this->conf, true);
    }

    public function get($attr=null)
    {
        if(!$attr) {
            return $this->conf;
        }

        if(isset($this->conf[$attr])) {
            return $this->conf[$attr];
        }

        throw new ConfigException("The atribute {$attr} does not exists.");
    }

    public function offsetUnset ($attr)
    {
        unset($this->conf[$attr]);
    }

    public function offsetSet($attr, $value)
    {
        $this->conf[$attr] = $value;
    }

    public function offsetget($attr)
    {
        return $this->get($attr);
    }

    public function offsetExists($attr)
    {
       return array_key_exists($attr, $this->conf);
    }

    protected function defaults()
    {
        return array();
    }

    public static function make($files)
    {
        if(!is_array($files)) {
            $files = array($files);
        }
        $loaders = array();
        foreach ($files as $k => $f) {
            $loaders[] = Tunny::parseFileExtension($f);
        }
        return new static($loaders);
    }
}
