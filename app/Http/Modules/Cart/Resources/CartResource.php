<?php

namespace App\Http\Modules\Cart\Resources;

use App\Http\Resources\Resource;
use App\Models\Cart;

class CartResource extends Resource
{
    private Cart $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->cart->{Cart::ID},
            'cartItems' => array_map(
                fn($item) => (new CartItemResource($item))->toArray(),
                $this->cart->getItems()
            ),
        ];
    }
}
