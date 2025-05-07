<?php
namespace App\Core;

interface AuthInterface {
    public function login(string $elpastas, string $slaptazodis): string;
    public function logout(): string;
}
