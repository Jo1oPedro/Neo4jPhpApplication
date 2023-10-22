<?php

namespace Project\Neo4j\Orm;

/** @psalm-suppress UnusedClass */
class CypherOrm
{
    /** @var object|null */
    protected ?\stdClass $data = null;

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

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __set(string $name, mixed $value)
    {
        if(is_null($this->data)) {
            $this->data = new \stdClass();
        }
        $this->data->$name = $value;
    }

    public function __get(string $name)
    {
        return $this->data->$name;
    }

    public function get(): String
    {

    }
}
