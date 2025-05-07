<?php
namespace App\Core;

abstract class AbstractUser {
    protected string $name;
    protected string $email;
    protected string $password;

    public function __construct(string $vardas, string $elpastas, string $slaptazodis) {
        $this->name = $vardas;
        $this->email = $elpastas;
        $this->password = password_hash($slaptazodis, PASSWORD_DEFAULT);
    }

    abstract public function userRole(): string;
}
