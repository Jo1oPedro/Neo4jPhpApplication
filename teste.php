<?php

require __DIR__ . '/vendor/autoload.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Project\Neo4j\Orm\CypherOrm;
use Project\Neo4j\Orm\User;

$url = DATABASE['url'];
$auth = Authenticate::basic(DATABASE['username'], DATABASE['password']);

$client = ClientBuilder::create()
    ->withDriver('neo4j+s', $url, $auth) // creates an auto routed driver with an OpenID Connect token
    ->build();


/*
    MATCH (n:user)
    WITH COUNT(n) AS numeroDeUsuarios

    MATCH (a:address)
    WITH numeroDeUsuarios, COUNT(a) AS numeroDeEnderecos

    MATCH (w:work)
    WITH numeroDeUsuarios, numeroDeEnderecos, COUNT(w) AS numeroDeTrabalhos

    RETURN numeroDeUsuarios, numeroDeEnderecos, numeroDeTrabalhos;
 */

$user = new User();
$query = 'MATCH (n:user) WITH COUNT(n) AS numeroDeUsuarios RETURN numeroDeUsuarios;';
$localVariables = ["numeroDeUsuarios"];
$properties = ["n" => ["numeroDeUsuarios"]];

$response = $user->findAll($query, $localVariables, $properties);
var_dump($response[0]);