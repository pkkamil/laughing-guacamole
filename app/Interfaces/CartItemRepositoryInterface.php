<?php

namespace App\Interfaces;

use App\Models\CartItem;

interface CartItemRepositoryInterface
{
    public function create(CartItem $cartItem): void;
    public function update(CartItem $cartItem): void;
    public function delete(CartItem $cartItem): void;
}
