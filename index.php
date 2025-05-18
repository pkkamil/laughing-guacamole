<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Router;

use App\Http\Middlewares\{
    AdminMiddleware,
    AuthTokenMiddleware,
    LoggedMiddleware
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

Router::get('/', [\App\Http\Modules\Home\Controller::class, 'index']);
Router::get('/catalog', [\App\Http\Modules\Products\Controller::class, 'catalog']);
Router::get('/products/{id}', [\App\Http\Modules\Products\Controller::class, 'single']);
Router::get('/contact', [\App\Http\Modules\Contact\Controller::class, 'index']);
Router::post('/contact/submit', [\App\Http\Modules\Contact\Controller::class, 'submit']);
Router::get('/cart', [\App\Http\Modules\Cart\Controller::class, 'index']);

// Logged routes
Router::group(['middleware' => LoggedMiddleware::class], function () {
    Router::get('/account', [\App\Http\Modules\Auth\Controller::class, 'account']);

    Router::group(['middleware' => AdminMiddleware::class], function () {
        Router::get('/admin', [\App\Http\Modules\Auth\Controller::class, 'admin']);
        Router::get('/admin/settings', [\App\Http\Modules\Auth\Controller::class, 'settings']);
        Router::get('/admin/products', [\App\Http\Modules\Products\Controller::class, 'list']);
        Router::get('/admin/products/new', [\App\Http\Modules\Products\Controller::class, 'viewCreate']);
        Router::get('/admin/products/edit/{id}', [\App\Http\Modules\Products\Controller::class, 'viewEdit']);
        Router::get('/admin/products/{id}', [\App\Http\Modules\Products\Controller::class, 'single']);
        Router::post('/admin/products', [\App\Http\Modules\Products\Controller::class, 'create']);
        Router::post('/admin/products/{id}', [\App\Http\Modules\Products\Controller::class, 'update']);
        Router::post('/admin/products/{id}/delete', [\App\Http\Modules\Products\Controller::class, 'delete']);
    });
});

Router::get('/login', [\App\Http\Modules\Auth\Controller::class, 'login']);
Router::post('/login', [\App\Http\Modules\Auth\Controller::class, 'login']);
Router::get('/register', [\App\Http\Modules\Auth\Controller::class, 'register']);
Router::post('/register', [\App\Http\Modules\Auth\Controller::class, 'register']);
Router::get('/reset', [\App\Http\Modules\Auth\Controller::class, 'reset']);
Router::post('/reset', [\App\Http\Modules\Auth\Controller::class, 'reset']);
Router::post('/logout', [\App\Http\Modules\Auth\Controller::class, 'logout']);

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
Router::run($path);
