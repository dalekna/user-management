<?php
namespace App\Core;

class Database {
    private static ?Database $instance = null;
    private \PDO $pdo;

    private function __construct() {
        $nustatymai = require __DIR__ . '/../../config.php';
        $dsn = "mysql:host={$nustatymai['host']};dbname={$nustatymai['dbname']};charset=utf8";
        $this->pdo = new \PDO($dsn, $nustatymai['username'], $nustatymai['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): self {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO {
        return $this->pdo;
    }
}
