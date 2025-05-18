<?php

namespace App\Http\Modules\Products\Resources;

use App\Http\Resources\Resource;
use App\Models\Product;

class ProductResource extends Resource
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->product->{Product::ID},
            'createdAt' => $this->product->{Product::CREATED_AT},
            'updatedAt' => $this->product->{Product::UPDATED_AT},
            'name' => $this->product->{Product::NAME},
            'description' => $this->product->{Product::DESCRIPTION},
            'imageUrl' => $this->product->{Product::IMAGE_URL},
            'price' => $this->product->{Product::PRICE},
            'stock' => $this->product->{Product::STOCK},
            'link' => '/products/' . $this->product->{Product::ID},
            'availability' => $this->product->{Product::STOCK} > 0 ? 1 : 0,
        ];
    }
}
