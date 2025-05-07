<?php
namespace App\Models;

use App\Core\Database;
use App\Core\AbstractUser;
use App\Core\LoggerTrait;

class User extends AbstractUser {
    use LoggerTrait;

    private \PDO $pdo;
    private string $role;

    public function __construct(string $vardas, string $elpastas, string $slaptazodis, string $rolė = 'user') {
        parent::__construct($vardas, $elpastas, $slaptazodis);
        $this->pdo = Database::getInstance()->getConnection();
        $this->role = $rolė;
    }

    public function userRole(): string {
        return $this->role;
    }

    public function issaugoti(): bool {
        try {
            $uzklausa = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $rezultatas = $uzklausa->execute([$this->name, $this->email, $this->password, $this->role]);
            $this->log("Naujas vartotojas: {$this->email}");
            return $rezultatas;
        } catch (\PDOException $klaida) {
            $this->log("Klaida įrašant vartotoją: " . $klaida->getMessage());
            return false;
        }
    }

    public static function rastiPagalElpastą(string $elpastas): ?array {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$elpastas]);
        $rez = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $rez ?: null;
    }
}
