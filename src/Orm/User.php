<?php

namespace Project\Neo4j\Orm;

class User extends CypherOrm
{
    public function __construct()
    {
        parent::__construct("user");
    }
}
