<?php

namespace App\Commands;

use App\Repositories\AuthTokenRepository;

// External dependencies
use Exception;

$repository = new AuthTokenRepository();

try {
    $repository->deleteExpiredTokens();
    echo "[" . date('Y-m-d H:i:s') . "] ✅ Expired tokens cleaned up.\n";
} catch (Exception $e) {
    echo "[" . date('Y-m-d H:i:s') . "] ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
