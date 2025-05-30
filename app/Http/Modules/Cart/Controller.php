<?php

namespace App\Http\Modules\Cart;

use App\Http\Controllers\BaseController;
use App\Http\Modules\Cart\Requests\{
    AddToCartRequest,
    RemoveFromCartRequest,
    UpdateQuantityRequest
};
use App\Http\Modules\Cart\Resources\CartItemResource;
use App\Repositories\{
    CartItemRepository,
    CartRepository,
    ProductRepository,
};

use App\Http\Modules\Cart\Resources\CartResource;
use App\Http\Modules\Products\Resources\ProductResource;
use App\Models\Cart;
use App\Models\CartItem;

class Controller extends BaseController
{
    private CartRepository $cartRepository;
    private CartItemRepository $cartItemRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->cartRepository = new CartRepository();
        $this->cartItemRepository = new CartItemRepository();
        $this->productRepository = new ProductRepository();
    }

    public function index()
    {
        $cart = $this->cartRepository->findByUserId($_SESSION['user']->getId());

        if (!$cart) {
            $cart = new Cart();
            $cart->setUserId($_SESSION['user']->getId());
            $cart->setStatus(Cart::STATUS_ACTIVE);
            $this->cartRepository->create($cart);
        }

        $products = $this->productRepository->get();

        $products = array_map(function ($product) {
            return (new ProductResource($product))->toArray();
        }, $products);

        // Limit the number of products to 4
        $products = array_slice($products, 0, 4);

        $this->render('cart', [
            'cart' => (new CartResource($cart))->toArray(),
            'products' => $products,
        ]);
    }

    public function addToCart()
    {
        $request = new AddToCartRequest($_POST);
        $request->validate();

        // Return json response if validation fails
        if ($request->fails()) {
            return json_encode([
                'status' => 'error',
                'errors' => $request->errors(),
            ]);
        }

        $validated = $request->validated();

        $cart = $this->cartRepository->findByUserId($_SESSION['user']->getId());

        if (!$cart) {
            $cart = new Cart();
            $cart->setUserId($_SESSION['user']->getId());
            $cart->setStatus(Cart::STATUS_ACTIVE);
            $cart = $this->cartRepository->create($cart);
        }

        $productId = $validated['productId'];
        $quantity = $validated['quantity'];

        // Check if the product already exists in the cart
        $existingItem = $this->cartItemRepository->findByCartIdAndProductId($cart->getId(), $productId);
        if ($existingItem) {
            // Update the quantity of the existing item
            $existingItem->setQuantity($existingItem->getQuantity() + $quantity);
            $this->cartItemRepository->update($existingItem->getId(), $existingItem);
            return json_encode([
                'status' => 'success',
                'message' => 'Product quantity has been updated in the cart.',
            ]);
        }

        $cartItem = new CartItem();
        $cartItem->setCartId($cart->getId());
        $cartItem->setProductId($productId);
        $cartItem->setQuantity($quantity);

        $this->cartItemRepository->create($cartItem);

        return json_encode([
            'status' => 'success',
            'message' => 'Product has been added to the cart.',
        ]);
    }

    public function removeFromCart()
    {
        header('Content-Type: application/json');

        $request = new RemoveFromCartRequest($_POST);
        $request->validate();

        if ($request->fails()) {
            echo json_encode([
                'status' => 'error',
                'errors' => $request->errors()
            ]);
            return;
        }

        $validated = $request->validated();

        $cartItemId = $validated['cartItemId'];
        if ($cartItemId) {
            $this->cartItemRepository->delete($cartItemId);
        }

        echo json_encode(['status' => 'success']);
        return;
    }

    public function updateQuantity()
    {
        header('Content-Type: application/json');

        $request = new UpdateQuantityRequest($_POST);
        $request->validate();

        if ($request->fails()) {
            echo json_encode([
                'status' => 'error',
                'errors' => $request->errors()
            ]);
            return;
        }

        $validated = $request->validated();
        $cartItemId = $validated['cartItemId'];
        $quantity = (int) $validated['quantity'];

        $cart = $this->cartRepository->findByUserId($_SESSION['user']->getId());

        $found = false;
        foreach ($cart->getItems() as $item) {
            if ($item->getId() == $cartItemId) {
                $item->setQuantity($quantity);
                $this->cartItemRepository->update($cartItemId, $item);
                $found = true;
                break;
            }
        }

        if ($found) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'errors' => 'Product not found']);
        }
        return;
    }

    public function getCartItems()
    {
        header('Content-Type: application/json');

        $cart = $this->cartRepository->findByUserId($_SESSION['user']->getId());

        if (!$cart) {
            echo json_encode(['status' => 'error', 'errors' => 'Cart not found']);
            return;
        }

        $cartItems = array_map(
            fn($item) => (new CartItemResource($item))->toArray(),
            $cart->getItems()
        );

        echo json_encode([
            'status' => 'success',
            'cartItems' => $cartItems,
        ]);
        return;
    }
}
