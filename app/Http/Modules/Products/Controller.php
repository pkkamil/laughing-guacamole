<?php

namespace App\Http\Modules\Products;

// External dependencies
use DateTime;

use App\Http\Controllers\BaseController;

use App\Http\Modules\Products\Requests\{
    CreateRequest,
    UpdateRequest
};
use App\Models\User;

use App\Repositories\{
    AuthTokenRepository,
    ProductRepository,
    UserRepository
};

use App\Http\Modules\Products\Resources\ProductResource;
use App\Models\Product;

class Controller extends BaseController
{
    private UserRepository $userRepository;
    private AuthTokenRepository $authTokenRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->authTokenRepository = new AuthTokenRepository();
        $this->productRepository = new ProductRepository();
    }

    public function catalog()
    {
        $products = $this->productRepository->get();

        $products = array_map(function ($product) {
            return (new ProductResource($product))->toArray();
        }, $products);

        $this->render('catalog', [
            'products' => $products,
        ]);
    }

    public function list()
    {
        $products = $this->productRepository->get();

        $products = array_map(function ($product) {
            return (new ProductResource($product))->toArray();
        }, $products);

        $this->render('auth/admin/products/list', ['products' => $products]);
    }

    public function single($id)
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            header('Location: /404');
            exit;
        }

        $this->render('product', [
            'product' => (new ProductResource($product))->toArray(),
        ]);
    }

    public function viewCreate()
    {
        $this->render('auth/admin/products/create');
    }

    public function viewEdit($id)
    {
        $product = $this->productRepository->findById($id);

        $this->render('auth/admin/products/edit', [
            'product' => (new ProductResource($product))->toArray(),
        ]);
    }

    public function create() // TODO: With image upload it does not work
    {
        $request = new CreateRequest($_POST);
        $request->validate();

        if ($request->fails()) {
            return $this->render('/auth/admin/products/create', [
                'errors' => $request->errors(),
                'old' => $_POST,
            ]);
        }

        $data = $request->validated();

        $this->productRepository->create(Product::fromArray([
            Product::NAME => $data['name'],
            Product::DESCRIPTION => $data['description'],
            Product::PRICE => $data['price'],
            Product::STOCK => $data['stock'],
            Product::IMAGE_URL => $data['image'],
        ]));

        header('Location: /admin/products');

        $this->render('auth/admin/products', [
            'messages' => ['Produkt został dodany.'],
        ]);
    }

    public function update($id) // TODO: With image upload it does not work
    {
        $request = new UpdateRequest($_POST);
        $request->validate();

        if ($request->fails()) {
            return $this->render('/auth/admin/products/edit', [
                'errors' => $request->errors(),
                'old' => $_POST,
                'product' => (new ProductResource($this->productRepository->findById($id)))->toArray(),
            ]);
        }

        $data = $request->validated();

        $this->productRepository->update($id, Product::fromArray([
            Product::NAME => $data['name'],
            Product::DESCRIPTION => $data['description'],
            Product::PRICE => $data['price'],
            Product::STOCK => $data['stock'],
            Product::IMAGE_URL => $data['image'],
        ]));

        $product = $this->productRepository->findById($id);

        header('Location: /admin/products/edit/' . $id);

        $this->render('auth/admin/products/edit', [
            'product' => (new ProductResource($product))->toArray(),
        ]);
    }

    public function delete($id)
    {
        $this->productRepository->delete($id);

        header('Location: /admin/products');

        $this->render('auth/admin/products/list', [
            'messages' => ['Produkt został usunięty.'],
        ]);
    }
}
