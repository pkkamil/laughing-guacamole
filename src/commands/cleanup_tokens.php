<?php

require_once __DIR__ . '/../repositories/AuthTokenRepository.php';

$repository = new AuthTokenRepository();

try {
    $repository->deleteExpiredTokens();
    echo "[" . date('Y-m-d H:i:s') . "] ✅ Expired tokens cleaned up.\n";
} catch (Exception $e) {
    echo "[" . date('Y-m-d H:i:s') . "] ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
