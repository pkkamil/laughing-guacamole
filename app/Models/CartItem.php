<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class CartItem extends MysqlModel
{
    private int $cartId;
    private int $productId;
    private int $quantity;

    public const TABLE_NAME = 'cart_items';

    public const CART_ID = 'cartId';
    public const PRODUCT_ID = 'productId';
    public const QUANTITY = 'quantity';

    public function getCartId(): int
    {
        return $this->{self::CART_ID};
    }

    public function setCartId(int $cartId): void
    {
        $this->{self::CART_ID} = $cartId;
    }

    public function getProductId(): int
    {
        return $this->{self::PRODUCT_ID};
    }

    public function setProductId(int $productId): void
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

    public static function fromArray(array $data): static
    {
        $cartItem = new static();
        $cartItem->setId($data['id'] ?? '');
        $cartItem->setCreatedAt($data['created_at'] ?? '');
        $cartItem->setUpdatedAt($data['updated_at'] ?? '');
        $cartItem->setCartId((int)($data['cart_id'] ?? 0));
        $cartItem->setProductId((int)($data['product_id'] ?? 0));
        $cartItem->setQuantity((int)($data['quantity'] ?? 1));

        return $cartItem;
    }
}
