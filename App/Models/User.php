<?php
namespace App\Models;

use App\Core\Database;
use App\Core\AbstractUser;
use App\Core\LoggerTrait;

class User extends AbstractUser {
    use LoggerTrait;

    private \PDO $pdo;
    private string $role;

    public function __construct(string $vardas, string $pavarde, string $elpastas, string $slaptazodis, string $rolė = 'user') {
        parent::__construct($vardas, $pavarde, $elpastas, $slaptazodis);
        $this->pdo = Database::getInstance()->getConnection();
        $this->role = $rolė;
    }

    public function userRole(): string {
        return $this->role;
    }

    public function issaugoti(): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, surname, email, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->getName(),
                $this->getSurname(),
                $this->getEmail(),
                $this->getPassword(),
                $this->role,
                $this->getCreatedAt()
            ]);
            $this->log("Naujas vartotojas: {$this->getEmail()}");
            return $result;
        } catch (\PDOException $e) {
            $this->log("Klaida įrašant vartotoją: " . $e->getMessage());
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
