<?php

namespace unit\Database;

use PHPUnit\Framework\TestCase;
use Project\Neo4j\Database\Database;

class DatabaseConnectionTest extends TestCase
{
    public function testDeveRetornarConexaoComSucesso()
    {
        $this->assertTrue(Database::getInstance()->verifyConnectivity());
    }
}