<?php

namespace App\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function create(Product $product): void;
    public function update(string $id, Product $product): void;
}
