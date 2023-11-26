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



    $addressPath = 'input/AddressRelationship.csv';
    $workPath = 'input/WorkRelationship.csv';
    $friendPath = 'input/FriendRelationship.csv';

    $addressFile = fopen($addressPath, 'r');
    $workFile = fopen($workPath, 'r');
    $friendFile = fopen($friendPath, 'r');


    if ($friendPath) {
        // Pula a primeira linha
        $counter = 0;
        $linha = fgetcsv($friendFile);
    while (($linha = fgetcsv($friendFile)) !== false) {
        $arr = str_getcsv($linha[0], ";", '"');
        $id_1 = $arr[0];
        $id_2 = $arr[1];

        $query = "MATCH (u1:user {id: ". $id_1 ."}), (u2:user {id: ". $id_2 ."}) CREATE (u1)-[:Follow]->(u2);";
        $client->run($query);
        $counter++;
        print_r("\nNumero de querys feitas: " . $counter);
    }

    fclose($friendFile);
    } else {
        echo "Erro ao abrir o arquivo CSV.";
    }