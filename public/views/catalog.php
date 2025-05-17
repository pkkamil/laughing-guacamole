<?php
$title = "Katalog produktów";
$catalog = true;

$products = [
    (object)[
        'name' => 'Kierownica samochodowa',
        'price' => 99.99,
        'image' => '/public/img/products/product1.jpg',
        'link' => '/product/1'
    ],
    (object)[
        'name' => 'Opony BRIDGESTONE Blizzak 205/55R16',
        'price' => 360.00,
        'image' => '/public/img/products/product2.jpg',
        'link' => '/product/2'
    ],
    (object)[
        'name' => 'Zestaw felg do samochodu',
        'price' => 299.99,
        'image' => '/public/img/products/product3.jpg',
        'link' => '/product/3'
    ],
    (object)[
        'name' => 'Zestaw felg do samochodu',
        'price' => 599.99,
        'image' => '/public/img/products/product4.jpg',
        'link' => '/product/4'
    ],
    (object)[
        'name' => 'Klocki hamulcowe do samochodu',
        'price' => 299.99,
        'image' => '/public/img/products/product5.jpg',
        'link' => '/product/5'
    ],
    (object)[
        'name' => 'Zaciski hamulcowe do samochodu',
        'price' => 499.99,
        'image' => '/public/img/products/product6.jpg',
        'link' => '/product/6'
    ],
    (object)[
        'name' => 'Zestaw felg do samochodu',
        'price' => 299.99,
        'image' => '/public/img/products/product7.jpg',
        'link' => '/product/7'
    ],
    (object)[
        'name' => 'Reflektor samochodowy',
        'price' => 899.99,
        'image' => '/public/img/products/product8.jpg',
        'link' => '/product/8'
    ]
]
?>

<article class="catalog">
    <?php include_once __DIR__ . '/products.php'; ?>
</article>