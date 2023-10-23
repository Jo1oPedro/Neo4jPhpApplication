<?php

require __DIR__ . '/vendor/autoload.php';

use Project\Neo4j\Database\Database;

$user = new \Project\Neo4j\Orm\User();

//$users = $user->findAll('MATCH (n:User) RETURN n', ['n'], ['n' => ['name']]);

/*$user->find("MATCH (keanu:user {name:'Keanu Reeves'})
RETURN keanu", ['keanu'], ['keanu' => ['name']]);

dd($user('keanu.name'));*/

//$user->find('MATCH (n:User) RETURN n LIMIT 1', ['n'], ['n' => ['name']]);

//$user->create('MATCH (n:User) RETURN n LIMIT 1', ['n'], ['n' => ['name']]);

/*$user->create("CREATE (j:User {name:'cascata9'})-[r:follows]->(n:User {name: 'cascata10'})-[x:buys]->(p:Products {name: 'produto'})
            RETURN j,r,n", ['j,n,p'], ['j' => 'name', 'n' => 'name', 'p' => 'name']);*/

$users = $user->bulkCreate(
    [
        "CREATE (j:User {name:'cascata11'})-[r:follows]->(n:User {name: 'cascata12'})-[x:buys]->(p:Products {name: 'produto2'})
        RETURN j,n,p",
        "CREATE (j:User {name:'cascata13'})-[r:follows]->(n:User {name: 'cascata14'})-[x:buys]->(p:Products {name: 'produto3'})
        RETURN j,n,p"
    ],
    [
        ['j', 'n', 'p'],
        ['j' => 'n', 'p']
    ],
    [
        ['j' => 'name', 'n' => 'name', 'p' => 'name'],
        ['j' => 'name', 'n' => 'name', 'p' => 'name']
    ]
);

dd($users[0]('n.name'));

foreach($users as $user) {
    var_dump($user("n.name"));
}