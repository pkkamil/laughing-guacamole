<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\Cart;

class CartRepository extends Repository implements CartRepositoryInterface
{
    protected string $table = Cart::TABLE_NAME;
    protected string $modelClass = Cart::class;

    public function create(Cart $cart): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (user_id, status)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $cart->getUserId(),
            $cart->getStatus()
        ]);
    }

    public function update(Cart $cart): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                user_id = ?,
                status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $cart->getUserId(),
            $cart->getStatus(),
            $cart->getId()
        ]);
    }

    public function delete(Cart $cart): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$cart->getId()]);
    }
}
