<?php

namespace App\Http\Modules\Products;

// External dependencies
use DateTime;

use App\Http\Controllers\BaseController;

use App\Http\Modules\Products\Requests\{
    CreateRequest
};
use App\Models\User;

use App\Repositories\{
    AuthTokenRepository,
    UserRepository
};

use App\Http\Modules\Products\Resources\ProductResource;

class Controller extends BaseController
{
    private UserRepository $userRepository;
    private AuthTokenRepository $authTokenRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->authTokenRepository = new AuthTokenRepository();
    }

    public function catalog()
    {
        $this->render('catalog');
    }

    public function product($id)
    {
        $product = (object)[
            'id' => $id,
            'name' => 'Opony BRIDGESTONE Blizzak 205/55R16',
            'description' =>
            '
                Rozmiar opony: 205/55R16,
                Sezon: zima,
                Data produkcji: 2020,
                Indeks prędkości: H - 210 km/h,
                Indeks nośności: 91 - 615 kg
            ',
            'price' => 360.00,
            'availability' => 12,
            'quantity' => 12,
            'image' => '/public/img/products/product2.jpg',
        ];

        $this->render('product', ['product' => $product]);
    }
}
