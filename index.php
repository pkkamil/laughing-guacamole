<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('product', 'DefaultController');
Router::get('catalog', 'DefaultController');
Router::get('contact', 'DefaultController');
Router::get('cart', 'DefaultController');

Router::run($path);
