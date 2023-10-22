<?php

namespace Project\Neo4j\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

/** @psalm-suppress UnusedClass */
class MonoLog
{
    /**
     * Logger Instance
     * @var Logger|null
     */
    private static ?Logger $instance = null;

    /** @psalm-suppress UnusedConstructor */
    private function __construct()
    {
    }

    /**
     * Singleton method to retrieve the Logger instances so that we can log exceptions and debug
     * @return Logger|null
     */
    public static function getInstance(): Logger
    {
        if(is_null(self::$instance)) {
            self::setInstance();
        }
        return self::$instance;
    }

    /**
     * Configure the instance of the logger
     * @return void
     */
    private static function setInstance()
    {
        self::$instance = new Logger('neo4j', timezone: new \DateTimeZone('America/Sao_Paulo'));
        self::$instance->pushHandler(new StreamHandler(__DIR__ . '/../logs/log.txt', Level::Debug));
    }
}
