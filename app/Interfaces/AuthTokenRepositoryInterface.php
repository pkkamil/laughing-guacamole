<?php

namespace App\Interfaces;

use App\Models\AuthToken;

interface AuthTokenRepositoryInterface
{
    public function create(AuthToken $authToken): void;
    public function findBySelector(string $selector): ?AuthToken;
    public function deleteByUserId(string $userId): void;
    public function deleteExpiredTokens(): void;
}
