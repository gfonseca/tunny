<?php

require __DIR__."/../vendor/autoload.php";

$conf = \Tunny\Tunny::make([
    "/tmp/phparray2.php",
    "/tmp/jsontest.json",
    "/tmp/iniloader2.ini"
]);

echo $conf;
