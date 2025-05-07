<?php
namespace App\Services;

use App\Models\User;
use App\Core\AuthInterface;
use App\Core\LoggerTrait;
use App\Core\Database;

class AuthService implements AuthInterface {
    use LoggerTrait;

    private \PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function login(string $elpastas, string $slaptazodis): string {
        $naudotojas = User::rastiPagalElpastą($elpastas);
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'nežinomas';

        if ($naudotojas && password_verify($slaptazodis, $naudotojas['password'])) {
            session_start();
            $_SESSION['vartotojas'] = $naudotojas;
            $this->log("Prisijungė: {$elpastas}");
            $this->irasytiILog($elpastas, true, $ip);
            return "Sėkmingai prisijungta!";
        }

        $this->log("Neteisingas bandymas prisijungti: {$elpastas}");
        $this->irasytiILog($elpastas, false, $ip);
        return "Neteisingi prisijungimo duomenys!";
    }

    public function logout(): string {
        session_start();
        $elpastas = $_SESSION['vartotojas']['email'] ?? 'nežinomas';
        session_destroy();
        $this->log("Atsijungė: {$elpastas}");
        return "Sėkmingai atsijungta!";
    }

    public function register(string $vardas, string $pavarde, string $elpastas, string $slaptazodis): string {
        $naudotojas = new User($vardas, $pavarde, $elpastas, $slaptazodis);
        if ($naudotojas->issaugoti()) {
            return "Registracija sėkminga!";
        } else {
            return "Registracijos klaida!";
        }
    }

    public function changePassword(string $oldPassword, string $newPassword): string {
        session_start();
        if (!isset($_SESSION['vartotojas'])) {
            return "Turite būti prisijungęs.";
        }

        $naudotojas = $_SESSION['vartotojas'];

        if (!password_verify($oldPassword, $naudotojas['password'])) {
            return "Neteisingas dabartinis slaptažodis.";
        }

        $naujasHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$naujasHash, $naudotojas['id']]);

        $this->log("Vartotojas pakeitė slaptažodį: " . $naudotojas['email']);
        return "Slaptažodis sėkmingai pakeistas.";
    }

    public function isLoggedIn(): bool {
        session_start();
        return isset($_SESSION['vartotojas']);
    }

    private function irasytiILog(string $email, bool $sekme, string $ip): void {
        $stmt = $this->pdo->prepare("INSERT INTO log (email, success, ip_address) VALUES (?, ?, ?)");
        $stmt->execute([$email, $sekme, $ip]);
    }
}
