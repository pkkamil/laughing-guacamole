<?php

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\CartItem;

class CartItemRepository extends Repository implements CartItemRepositoryInterface
{
    protected string $table = CartItem::TABLE_NAME;
    protected string $modelClass = CartItem::class;

    public function create(CartItem $cartItem): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (cart_id, product_id, quantity)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $cartItem->getCartId(),
            $cartItem->getProductId(),
            $cartItem->getQuantity()
        ]);
    }

    public function update(CartItem $cartItem): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                cart_id = ?,
                product_id = ?,
                quantity = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $cartItem->getCartId(),
            $cartItem->getProductId(),
            $cartItem->getQuantity(),
            $cartItem->getId()
        ]);
    }

    public function delete(CartItem $cartItem): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$cartItem->getId()]);
    }
}
