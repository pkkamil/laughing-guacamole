<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;
use App\Repositories\CartItemRepository;

class Cart extends MysqlModel
{
    private ?string $userId = null;
    private string $status;

    public const TABLE_NAME = 'carts';

    public const USER_ID = 'userId';
    public const STATUS = 'status';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';


    public function getUserId(): ?string
    {
        return $this->{self::USER_ID};
    }

    public function setUserId(?string $userId): void
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

    /*
    ** RELATIONS
    */
    public function getItems(): array
    {
        if ($this->getId() === null) return [];

        $repository = new CartItemRepository();
        return $repository->findByCartId($this->getId());
    }

    public static function fromArray(array $data): static
    {
        $cart = new static();
        $cart->setId($data['id'] ?? $data[self::ID] ?? '');
        $cart->setCreatedAt($data['created_at'] ?? $data[self::CREATED_AT] ?? '');
        $cart->setUpdatedAt($data['updated_at'] ?? $data[self::UPDATED_AT] ?? '');
        $cart->userId = $data['user_id'] ?? $data[self::USER_ID] ?? null;
        $cart->setStatus($data['status'] ?? $data[self::STATUS] ?? self::STATUS_ACTIVE);

        return $cart;
    }
}
