<?php

namespace App\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function create(Product $product): void;
    public function update(Product $product): void;
    public function delete(Product $product): void;
}
