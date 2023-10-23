<?php

namespace Project\Neo4j\Database;

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;
use Laudis\Neo4j\Formatter\SummarizedResultFormatter;
use Project\Neo4j\Exceptions\DatabaseConnectionException;
use Project\Neo4j\Log\MonoLog;

/** @psalm-suppress UnusedClass */
class Database
{
    /** @var ClientInterface|null */
    private static ?ClientInterface $instance = null;

    /** @psalm-suppress UnusedConstructor */
    private function __construct()
    {
    }

    /**
     * Singleton method to retrieve the clientInterface instances so that we can make request to the database
     * @return ClientInterface
     */
    public static function getInstance(): ClientInterface
    {
        if(is_null(self::$instance)) {
            try {
                self::$instance = self::setInstance();
            } catch (DatabaseConnectionException) {
                MonoLog::getInstance()->debug('DatabseConnectionException');
                exit(1);
            }
        }
        return self::$instance;
    }

    /**
     * Configure the instance based on the values on the env.php file
     * @return ClientInterface
     * @throws DatabaseConnectionException
     */
    private static function setInstance(): ClientInterface
    {
        $auth = Authenticate::basic(DATABASE['username'], DATABASE['password']);

        $client = ClientBuilder::create()
            ->withFormatter(SummarizedResultFormatter::create())
            ->withDriver(DATABASE['alias'], DATABASE['url'], $auth) // creates an auto routed driver with an OpenID Connect token
            ->build();

        if(!$client->verifyConnectivity()) {
            throw new DatabaseConnectionException();
        }
        return $client;
    }
}
