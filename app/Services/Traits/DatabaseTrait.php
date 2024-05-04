<?php

namespace App\Services\Traits;

use App\DB\Connection;
use PDO;
use PDOException;

trait DatabaseTrait
{
    private PDO $pdo;

    public function setConnection()
    {
        try {
            $this->pdo = Connection::getInstance()::getConnection();
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function prepare($query)
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt;
    }

    public function execute($params = []) {
        $stmt = $this->prepare($params);
        $stmt->execute($params);
        return $stmt;
    }



}