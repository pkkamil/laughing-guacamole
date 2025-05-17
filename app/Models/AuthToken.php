<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class AuthToken extends MysqlModel
{
    private int $userId;
    private string $selector;
    private string $hashedValidator;
    private string $expiresAt;

    public const TABLE_NAME = 'auth_tokens';

    public const USER_ID = 'userId';
    public const SELECTOR = 'selector';
    public const HASHED_VALIDATOR = 'hashedValidator';
    public const EXPIRES_AT = 'expiresAt';

    public function getUserId(): int
    {
        return $this->{self::USER_ID};
    }

    public function setUserId(int $userId): void
    {
        $this->{self::USER_ID} = $userId;
    }

    public function getSelector(): string
    {
        return $this->{self::SELECTOR};
    }

    public function setSelector(string $selector): void
    {
        $this->{self::SELECTOR} = $selector;
    }

    public function getHashedValidator(): string
    {
        return $this->{self::HASHED_VALIDATOR};
    }

    public function setHashedValidator(string $hashedValidator): void
    {
        $this->{self::HASHED_VALIDATOR} = $hashedValidator;
    }

    public function getExpiresAt(): string
    {
        return $this->{self::EXPIRES_AT};
    }

    public function setExpiresAt(string $expiresAt): void
    {
        $this->{self::EXPIRES_AT} = $expiresAt;
    }

    public static function fromArray(array $data): static
    {
        $token = new static();
        $token->setId($data['id'] ?? $data[self::ID] ?? '');
        $token->setCreatedAt($data['created_at'] ?? $data[self::CREATED_AT] ?? '');
        $token->setUserId((int)($data['user_id'] ?? $data[self::USER_ID] ?? 0));
        $token->setSelector($data['selector'] ?? $data[self::SELECTOR] ?? '');
        $token->setHashedValidator($data['hashed_validator'] ?? $data[self::HASHED_VALIDATOR] ?? '');
        $token->setExpiresAt($data['expires_at'] ?? $data[self::EXPIRES_AT] ?? '');

        return $token;
    }
}
