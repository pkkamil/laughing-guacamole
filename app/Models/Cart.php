<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class Cart extends MysqlModel
{
    private ?int $userId = null;
    private string $status;

    public const TABLE_NAME = 'carts';

    public const USER_ID = 'userId';
    public const STATUS = 'status';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public function getUserId(): ?int
    {
        return $this->{self::USER_ID};
    }

    public function setUserId(?int $userId): void
    {
        $this->{self::USER_ID} = $userId;
    }

    public function getStatus(): string
    {
        return $this->{self::STATUS};
    }

    public function setStatus(string $status): void
    {
        $allowed = [
            self::STATUS_ACTIVE,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
        if (!in_array($status, $allowed)) {
            throw new \InvalidArgumentException('Invalid cart status');
        }
        $this->{self::STATUS} = $status;
    }

    public static function fromArray(array $data): static
    {
        $cart = new static();
        $cart->setId($data['id'] ?? '');
        $cart->setCreatedAt($data['created_at'] ?? '');
        $cart->setUpdatedAt($data['updated_at'] ?? '');
        $cart->userId = isset($data['user_id']) ? (int)$data['user_id'] : null;
        $cart->setStatus($data['status'] ?? self::STATUS_ACTIVE);

        return $cart;
    }
}
