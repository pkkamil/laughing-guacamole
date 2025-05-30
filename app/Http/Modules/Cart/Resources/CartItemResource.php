<?php

namespace App\Http\Modules\Cart\Resources;

use App\Http\Resources\Resource;
use App\Models\CartItem;
use App\Models\Product;

class CartItemResource extends Resource
{
    private CartItem $cartItem;

    public function __construct(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    public function toArray(): array
    {
        $product = $this->cartItem->getProduct();

        return [
            'id' => $this->cartItem->{CartItem::ID},
            'quantity' => $this->cartItem->{CartItem::QUANTITY},
            'image' => $product->{Product::IMAGE_URL},
            'name' => $product->{Product::NAME},
            'price' => $product->{Product::PRICE},
            'stock' => $product->{Product::STOCK},
            'link' => '/products/' . $product->{Product::ID},
        ];
    }
}
