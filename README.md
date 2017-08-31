# Tunny

[logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "T u n n y"

## A simple configuration file parse

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

network_json.json
```json
{
"system": {
	"os": "Fedora",
	"memory": 899789
	}
}
```

system_ini_file.ini
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

$tunny = \Tunny\Tunny::make([
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
