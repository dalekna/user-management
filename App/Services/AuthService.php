<?php
namespace App\Services;

use App\Models\User;
use App\Core\AuthInterface;
use App\Core\LoggerTrait;

class AuthService implements AuthInterface {
    use LoggerTrait;

    public function login(string $elpastas, string $slaptazodis): string {
        $naudotojas = User::rastiPagalElpastą($elpastas);

        if ($naudotojas && password_verify($slaptazodis, $naudotojas['password'])) {
            session_start();
            $_SESSION['vartotojas'] = $naudotojas;
            $this->log("Prisijungė: {$elpastas}");
            return "Sėkmingai prisijungta!";
        }

        $this->log("Neteisingas bandymas prisijungti: {$elpastas}");
        return "Neteisingi prisijungimo duomenys!";
    }

    public function logout(): string {
        session_start();
        $elpastas = $_SESSION['vartotojas']['email'] ?? 'nežinomas';
        session_destroy();
        $this->log("Atsijungė: {$elpastas}");
        return "Sėkmingai atsijungta!";
    }
}
