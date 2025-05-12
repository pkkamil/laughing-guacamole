<?php

require 'Routing.php';
require_once 'src/repositories/AuthTokenRepository.php';
require_once 'src/middlewares/AuthMiddleware.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

// Middleware to check if the user is logged in
$authMiddleware = new AuthMiddleware(new UserRepository(), new AuthTokenRepository());
$authMiddleware->handle();

Router::get('', 'DefaultController');
Router::get('product', 'DefaultController');
Router::get('catalog', 'DefaultController');
Router::get('contact', 'DefaultController');
Router::get('cart', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('reset', 'SecurityController');

Router::run($path);
