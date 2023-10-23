<?php

namespace Project\Neo4j\Orm;

use Laudis\Neo4j\Databags\Statement;
use Project\Neo4j\Database\Database;
use Project\Neo4j\Log\MonoLog;

/** @psalm-suppress UnusedClass */
abstract class CypherOrm implements Model
{
    /** @var null|\stdClass */
    protected null|\stdClass $data = null;

    /** @var String $entity */
    protected string $entity;

    /** @var String $query */
    protected string $query;

    /** @var string */
    protected string $order;

    /** @var int */
    protected string $limit;

    /** @var int */
    protected string $offset;

    /**
     * @param $entity
     */
    public function __construct($entity = '')
    {
        $this->entity = $entity;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value)
    {
        if(is_null($this->data)) {
            $this->data = new \stdClass();
        }
        $this->data->$name = $value;
    }

    /**
     * @param string $name
     * @return null
     */
    public function __get(string $name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data->$name);
    }

    /**
     * @param string $invoke
     * @return \stdClass|null
     */
    public function __invoke(string $invoke)
    {
        $arrayPositions = explode(".", $invoke);
        $value = $this->data;
        foreach($arrayPositions as $arrayPosition) {
            $value = $value->{$arrayPosition};
        }
        return $value;
    }

    /**
     * @return \stdClass|null
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @param string $query
     * @param string[] $localVariables
     * @param array $properties
     * @return CypherOrm[]
     */
    public function findAll(string $query, array $localVariables, array $properties)
    {
        try {
            $results = Database::getInstance()->run($query);
            $users = [];
            foreach($results as $result) {
                $user = new (get_called_class())();
                $users[] = $user;
                foreach($localVariables as $localVariable) {
                    $node = $result->get($localVariable);
                    $user->$localVariable = new \stdClass();
                    foreach($properties[$localVariable] as $property) {
                        $user->$localVariable->$property = $node->getProperty($property);
                    }
                }
            }
            return $users;
        } catch (\Exception $exception) {
            MonoLog::getInstance()->error($exception->getMessage() . " / " .  $exception->getCode());
        }
    }

    /**
     * @param string $query
     * @param string[] $localVariables
     * @param array $properties
     * @return void
     */
    public function find(string $query, array $localVariables, array $properties): void
    {
        try {
            $results = Database::getInstance()->run($query);
            foreach($results as $result) {
                foreach($localVariables as $localVariable) {
                    $node = $result->get($localVariable);
                    $this->$localVariable = new \stdClass();
                    foreach($properties[$localVariable] as $property) {
                        $this->$localVariable->$property = $node->getProperty($property);
                    }
                }
            }
        } catch (\Exception $exception) {
            MonoLog::getInstance()->error($exception->getMessage() . " / " .  $exception->getCode());
        }
    }

    /**
     * @param string $query
     * @param array $localVariables
     * @param array $properties
     * @return void
     */
    public function create(string $query, array $localVariables, array $properties)
    {
        try {
            $result = Database::getInstance()->run($query);
            foreach($localVariables as $localVariable) {
                $this->$localVariable = new \stdClass();
                $this->$localVariable->$properties[$localVariable] = $result->first()->get($localVariable)->getProperty($properties[$localVariable]);
            }
        } catch (\Exception $exception) {
            MonoLog::getInstance()->error($exception->getMessage() . " / " .  $exception->getCode());
        }
    }

    /**
     * @param string[] $querys
     * @param array $localVariables
     * @param array $properties
     * @return User[]
     */
    public function bulkCreate(array $querys, array $localVariables, array $properties)
    {
        try {
            $users = [];
            $statements = [];
            foreach($querys as $query) {
                $statements[] = Statement::create($query);
            }
            $results = Database::getInstance()->runStatements($statements);
            foreach($results as $key => $result) {
                $user = new (get_called_class())();
                foreach ($localVariables[$key] as $localVariable) {
                    $user->$localVariable = new \stdClass();
                    $user->$localVariable->{$properties[$key][$localVariable]} = $result->first()->get($localVariable)->getProperty($properties[$key][$localVariable]);
                }
                $users[] = $user;
            }
        } catch (\Exception $exception) {
            MonoLog::getInstance()->error($exception->getMessage() . " / " . $exception->getCode());
        }
        return $users;
    }
}
