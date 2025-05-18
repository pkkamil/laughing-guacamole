<?php

namespace App\Http\Modules\Home;

use App\Http\Controllers\BaseController;

use App\Models\User;

use App\Repositories\{
    ProductRepository,
    UserRepository
};

use App\Http\Modules\Auth\Resources\UserResource;
use App\Http\Modules\Products\Resources\ProductResource;

class Controller extends BaseController
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->productRepository = new ProductRepository();
    }

    public function index()
    {
        $products = $this->productRepository->get();

        $products = array_map(function ($product) {
            return (new ProductResource($product))->toArray();
        }, $products);

        // Limit the number of products to 8
        $products = array_slice($products, 0, 8);

        $this->render('homepage', [
            'products' => $products,
        ]);
    }
}
