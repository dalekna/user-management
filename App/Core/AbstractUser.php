<?php
namespace App\Core;

abstract class AbstractUser {
    protected string $name;
    protected string $surname;
    protected string $email;
    protected string $password;
    protected string $created_at;

    public function __construct(string $vardas, string $pavarde, string $elpastas, string $slaptazodis) {
        $this->name = $vardas;
        $this->surname = $pavarde;
        $this->email = $elpastas;
        $this->password = password_hash($slaptazodis, PASSWORD_DEFAULT);
        $this->created_at = date('Y-m-d H:i:s');
    }

    abstract public function userRole(): string;

    // Getteriai, jeigu reikia prieiti prie laukų
    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }
}
