# Tunny

![T u n n y](https://raw.githubusercontent.com/gfonseca/tunny/master/tunny.png "T u n n y")

[![tunny:master](https://travis-ci.org/gfonseca/tunny.svg?branch=master "T u n n y")](https://travis-ci.org/gfonseca/tunny)

## A simple configuration file parse

### Instalation:
```bash
$ composer require gfonseca/tunny
```

### Example:
system_php_array.php
```php
<?php

return array(
	"system" => array(
		"os" => "Ubuntu",
		"hd" => "1000000GB"
	)
);
```

system_json.json
```json
{
"system": {
	"os": "Fedora",
	"memory": 899789
	}
}
```

network_ini_file.ini
```ini
[system]
cpu = Intel
[network]
modem=U.S. Robotics
```

system_yaml.yml
```yaml
system:
    memory: 99999999
    environment:
        iface2: Gnome
```

sample.php
```php
<?php

require __DIR__."/../vendor/autoload.php";

$tunny = \Tunny\Config::make([
    "./system_php_array.php",
    "./network_json.json",
    "./system_ini_file.ini",
    "./system_yaml.yml"
]);


$conf = $tunny->get();
print_r($conf);
```

### Output:
```php
Array
(
    [system] => Array
        (
            [os] => Fedora
            [hd] => 1000000GB
            [memory] => 99999999
            [cpu] => Intel
            [environment] => Array
                (
                    [iface2] => Gnome
                )

        )

    [network] => Array
        (
            [modem] => U.S. Robotics
        )

)
```
