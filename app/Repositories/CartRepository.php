<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\Cart;

class CartRepository extends Repository implements CartRepositoryInterface
{
    protected string $table = Cart::TABLE_NAME;
    protected string $modelClass = Cart::class;

    public function findByUserId(string $userId): ?Cart
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data ? $this->mapToModel($data) : null;
    }

    public function create(Cart $cart): Cart
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (id, user_id, status)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $cart->generateUuid(),
            $cart->getUserId(),
            $cart->getStatus()
        ]);

        return $cart;
    }

    public function update(string $id, Cart $cart): Cart
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
            $id
        ]);

        return $cart;
    }
}
