<?php

require_once 'Repository.php';

class AuthTokenRepository extends Repository
{
    public function create(int $userId, string $selector, string $hashedValidator, DateTime $expiresAt): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO auth_tokens (user_id, selector, hashed_validator, expires_at)
            VALUES (:user_id, :selector, :hashed_validator, :expires_at)
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':selector' => $selector,
            ':hashed_validator' => $hashedValidator,
            ':expires_at' => $expiresAt->format('Y-m-d H:i:s'),
        ]);
    }

    public function findBySelector(string $selector): ?array
    {
        $stmt = $this->database->prepare("
            SELECT * FROM auth_tokens WHERE selector = :selector LIMIT 1
        ");
        $stmt->execute([':selector' => $selector]);
        $token = $stmt->fetch(PDO::FETCH_ASSOC);

        return $token ?: null;
    }

    public function deleteByUserId(int $userId): void
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
