<?php
namespace App\Core;

trait LoggerTrait {
    public function log(string $zinute): void {
        file_put_contents(__DIR__ . '/../../logs/log.txt', date('Y-m-d H:i:s') . " - $zinute\n", FILE_APPEND);
    }
}
