<?php

namespace App\Http\Modules\Cart;

use App\Http\Controllers\BaseController;

use App\Models\User;

use App\Repositories\{
    UserRepository
};

use App\Http\Modules\Auth\Resources\UserResource;

class Controller extends BaseController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        $this->render('cart');
    }
}
