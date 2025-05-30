<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;
use App\Repositories\ProductRepository;

class CartItem extends MysqlModel
{
    private string $cartId;
    private string $productId;
    private int $quantity;

    public const TABLE_NAME = 'cart_items';

    public const CART_ID = 'cartId';
    public const PRODUCT_ID = 'productId';
    public const QUANTITY = 'quantity';

    public function getCartId(): string
    {
        return $this->{self::CART_ID};
    }

    public function setCartId(string $cartId): void
    {
        $this->{self::CART_ID} = $cartId;
    }

    public function getProductId(): string
    {
        return $this->{self::PRODUCT_ID};
    }

    public function setProductId(string $productId): void
    {
        $this->{self::PRODUCT_ID} = $productId;
    }

    public function getQuantity(): int
    {
        return $this->{self::QUANTITY};
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than zero.');
        }
        $this->{self::QUANTITY} = $quantity;
    }

    /*
    ** RELATIONS
    */
    public function getProduct(): ?Product
    {
        if ($this->getProductId() === null) return null;

        $repository = new ProductRepository();
        return $repository->findById($this->getProductId());
    }

    public static function fromArray(array $data): static
    {
        $cartItem = new static();
        $cartItem->setId($data['id'] ?? $data[self::ID] ?? '');
        $cartItem->setCreatedAt($data['created_at'] ?? $data[self::CREATED_AT] ?? '');
        $cartItem->setUpdatedAt($data['updated_at'] ?? $data[self::UPDATED_AT] ?? '');
        $cartItem->setCartId($data['cart_id'] ?? $data[self::CART_ID] ?? 0);
        $cartItem->setProductId($data['product_id'] ?? $data[self::PRODUCT_ID] ?? 0);
        $cartItem->setQuantity((int)($data['quantity'] ?? $data[self::PRODUCT_ID] ?? 1));

        return $cartItem;
    }
}
