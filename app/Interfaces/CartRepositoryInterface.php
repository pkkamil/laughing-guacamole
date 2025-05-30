<?php

namespace App\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function findByUserId(string $userId): ?Cart;
    public function create(Cart $cart): Cart;
    public function update(string $id, Cart $cart): Cart;
}
