<?php

require __DIR__ . '/vendor/autoload.php';

use Project\Neo4j\Database\Database;

$database = Database::getInstance();

var_dump($database->verifyConnectivity());

$monolog = \Project\Neo4j\Log\MonoLog::getInstance();

//var_dump($monolog->debug('dale', ["logger" => true]));