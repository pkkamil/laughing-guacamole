<?php

namespace App\Repositories;

use App\Interfaces\AuthTokenRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\AuthToken;

class AuthTokenRepository extends Repository implements AuthTokenRepositoryInterface
{
    protected string $table = AuthToken::TABLE_NAME;
    protected string $modelClass = AuthToken::class;

    public function findBySelector(string $selector): ?AuthToken
    {
        $stmt = $this->database->prepare("
            SELECT * FROM auth_tokens WHERE selector = :selector LIMIT 1
        ");
        $stmt->execute([':selector' => $selector]);
        $token = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $token ? $this->mapToModel($token) : null;
    }

    public function create(AuthToken $authToken): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (id, user_id, selector, hashed_validator, expires_at)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $authToken->generateUuid(),
            $authToken->getUserId(),
            $authToken->getSelector(),
            $authToken->getHashedValidator(),
            $authToken->getExpiresAt()
        ]);
    }

    public function deleteByUserId(string $userId): void
    {
        $stmt = $this->database->prepare("
            DELETE FROM auth_tokens WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
    }

    public function deleteExpiredTokens(): void
    {
        $stmt = $this->database->prepare("
            DELETE FROM auth_tokens WHERE expires_at < NOW()
        ");
        $stmt->execute();
    }
}
