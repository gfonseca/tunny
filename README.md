# Atune

## A simple configuration file parse

### Example:
```php
<?php

require __DIR__."/../vendor/autoload.php";

$conf = \Tunny\Tunny::make([
    "/tmp/phparray1.php",
    "/tmp/phparray2.php",
    "/tmp/json_conf.json",
    "/tmp/ini_conf.ini"
]);

print_r($conf->get("system"));

print_r($conf["network"]);
```
