<?php
namespace App\Core;

trait LoggerTrait {
    public function log(string $zinute): void {
        $logDir = __DIR__ . '/../../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'NEŽINOMAS_IP';
        $laikas = date('Y-m-d H:i:s');
        $tekstas = "$laikas - $ip - $zinute\n";
        file_put_contents($logDir . '/log.txt', $tekstas, FILE_APPEND);
    }
}
