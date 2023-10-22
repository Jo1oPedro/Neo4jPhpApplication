<?php

require __DIR__ . '/vendor/autoload.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

$url = 'neo4j+s://ec049450.databases.neo4j.io';
$auth = Authenticate::basic('neo4j', 'VtY3a4688YMIbUeNhqXVq9LN_xmDpQ3P5ln4dtrgEIw');

$client = ClientBuilder::create()
    ->withDriver('neo4j+s', $url, $auth) // creates an auto routed driver with an OpenID Connect token
    ->build();

$results = $client->run('CREATE (:User {name: "@cascata2"})');

var_dump($results);