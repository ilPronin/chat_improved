<?php

namespace App\DB;
use Exception;
use PDO;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance()::getConnection();
    }

    public function addData($query, $params): void
    {
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute($params);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}