<?php

namespace App\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function create(Cart $cart): void;
    public function update(string $id, Cart $cart): void;
}
