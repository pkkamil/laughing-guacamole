<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Router;

use App\Http\Middlewares\{
    AdminMiddleware,
    AuthTokenMiddleware,
    LoggedMiddleware
};
use App\Http\Modules\{
    DefaultController,
    SecurityController
};
use App\Repositories\{
    UserRepository,
    AuthTokenRepository
};

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

// Middleware to check if the user is logged in 
$authTokenMiddleware = new AuthTokenMiddleware(new UserRepository(), new AuthTokenRepository());
$authTokenMiddleware->handle($path);

Router::get('', \App\Http\Modules\Home\Controller::class);
Router::get('catalog', \App\Http\Modules\Products\Controller::class);
Router::get('product', \App\Http\Modules\Products\Controller::class);
Router::get('contact', \App\Http\Modules\Contact\Controller::class);
Router::post('submit', \App\Http\Modules\Contact\Controller::class);
Router::get('cart', \App\Http\Modules\Cart\Controller::class);

// Logged routes
Router::group(['middleware' => LoggedMiddleware::class], function () {
    Router::get('account', \App\Http\Modules\Auth\Controller::class);

    Router::group(['middleware' => AdminMiddleware::class], function () {
        Router::get('admin', \App\Http\Modules\Auth\Controller::class);
    });
});

Router::get('login', \App\Http\Modules\Auth\Controller::class);
Router::post('login', \App\Http\Modules\Auth\Controller::class);
Router::get('register', \App\Http\Modules\Auth\Controller::class);
Router::post('register', \App\Http\Modules\Auth\Controller::class);
Router::get('reset', \App\Http\Modules\Auth\Controller::class);
Router::post('reset', \App\Http\Modules\Auth\Controller::class);
Router::post('logout', \App\Http\Modules\Auth\Controller::class);

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
Router::run($path);
