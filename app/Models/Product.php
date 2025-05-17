<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class Product extends MysqlModel
{
    private string $name;
    private ?string $description = null;
    private ?string $imageUrl = null;
    private float $price;
    private int $stock;

    public const TABLE_NAME = 'products';

    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const IMAGE_URL = 'imageUrl';
    public const PRICE = 'price';
    public const STOCK = 'stock';

    public function getName(): string
    {
        return $this->{self::NAME};
    }

    public function setName(string $name): void
    {
        $this->{self::NAME} = $name;
    }

    public function getDescription(): ?string
    {
        return $this->{self::DESCRIPTION};
    }

    public function setDescription(?string $description): void
    {
        $this->{self::DESCRIPTION} = $description;
    }

    public function getImageUrl(): ?string
    {
        return $this->{self::IMAGE_URL};
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->{self::IMAGE_URL} = $imageUrl;
    }

    public function getPrice(): float
    {
        return $this->{self::PRICE};
    }

    public function setPrice(float $price): void
    {
        $this->{self::PRICE} = $price;
    }

    public function getStock(): int
    {
        return $this->{self::STOCK};
    }

    public function setStock(int $stock): void
    {
        $this->{self::STOCK} = $stock;
    }

    public static function fromArray(array $data): static
    {
        $product = new static();
        $product->setId($data['id'] ?? '');
        $product->setCreatedAt($data['created_at'] ?? '');
        $product->setUpdatedAt($data['updated_at'] ?? '');
        $product->name = $data['name'];
        $product->description = $data['description'] ?? null;
        $product->imageUrl = $data['image_url'] ?? null;
        $product->price = (float) $data['price'];
        $product->stock = (int) $data['stock'];

        return $product;
    }
}
