<?php

namespace App\Interfaces;

use App\Models\CartItem;

interface CartItemRepositoryInterface
{
    public function findByCartId(string $cartId): array;
    public function create(CartItem $cartItem): void;
    public function update(string $id, CartItem $cartItem): void;
}
