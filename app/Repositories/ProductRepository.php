<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\Product;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    protected string $table = Product::TABLE_NAME;
    protected string $modelClass = Product::class;

    public function create(Product $product): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (name, description, image_url, price, stock)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $product->getName(),
            $product->getDescription(),
            $product->getImageUrl(),
            $product->getPrice(),
            $product->getStock()
        ]);
    }

    public function update(Product $product): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                name = ?,
                description = ?,
                image_url = ?,
                price = ?,
                stock = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $product->getName(),
            $product->getDescription(),
            $product->getImageUrl(),
            $product->getPrice(),
            $product->getStock(),
            $product->getId()
        ]);
    }

    public function delete(Product $product): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$product->getId()]);
    }
}
