<?php

spl_autoload_register(function ($klasesPavadinimas) {
    $failas = __DIR__ . '/' . str_replace('\\', '/', $klasesPavadinimas) . '.php';
    if (file_exists($failas)) {
        require $failas;
    }
});
