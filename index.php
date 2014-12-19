<?php
use Otacioglu\Bytect\Bytect;
use Otacioglu\Support\Config;

require __DIR__ . '/src/start.php';

$dbType = Config::get('defaultDriver');

$connect = new Bytect($dbType);