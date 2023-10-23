<?php

namespace Project\Neo4j\Orm;

interface Model
{
    public function __set(string $name, mixed $value);
    public function __get(string $name);
    public function __isset(string $name);
    public function __invoke(string $invoke);
    public function data();
    public function findAll(string $query, array $localVariables, array $properties);
    public function find(string $query, array $localVariables, array $properties): void;
    public function create(string $query, array $localVariables, array $properties);
}