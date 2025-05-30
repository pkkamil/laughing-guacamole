<?php

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\CartItem;

class CartItemRepository extends Repository implements CartItemRepositoryInterface
{
    protected string $table = CartItem::TABLE_NAME;
    protected string $modelClass = CartItem::class;

    public function findByCartId(string $cartId): array
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToModel'], $data);
    }

    public function findByCartIdAndProductId(string $cartId, string $productId): ?CartItem
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE cart_id = :cart_id AND product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $productId, \PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data ? $this->mapToModel($data) : null;
    }

    public function create(CartItem $cartItem): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (id, cart_id, product_id, quantity)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $cartItem->generateUuid(),
            $cartItem->getCartId(),
            $cartItem->getProductId(),
            $cartItem->getQuantity()
        ]);
    }

    public function update(string $id, CartItem $cartItem): void
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
            $id
        ]);
    }
}
