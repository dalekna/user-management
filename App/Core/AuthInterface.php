<?php
namespace App\Core;

interface AuthInterface {
    public function register(string $vardas, string $pavarde, string $elpastas, string $slaptazodis): string;
    public function login(string $elpastas, string $slaptazodis): string;
    public function logout(): string;
    public function changePassword(string $oldPassword, string $newPassword): string;
    public function isLoggedIn(): bool;
}
