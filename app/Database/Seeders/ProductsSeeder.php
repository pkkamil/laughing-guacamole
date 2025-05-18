<?php

namespace App\Database\Seeders;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductsSeeder
{
    private array $products = [
        [
            'name' => 'Kierownica samochodowa',
            'price' => 99.99,
            'image' => '/public/img/products/product1.jpg',
            'description' => 'Ergonomiczna kierownica samochodowa, idealna do tuningu wnętrza auta.',
            'stock' => 25
        ],
        [
            'name' => 'Opony BRIDGESTONE Blizzak 205/55R16',
            'price' => 360.00,
            'image' => '/public/img/products/product2.jpg',
            'description' => 'Zimowe opony BRIDGESTONE Blizzak zapewniające doskonałą przyczepność na śniegu i lodzie.',
            'stock' => 80
        ],
        [
            'name' => 'Zestaw felg do samochodu',
            'price' => 299.99,
            'image' => '/public/img/products/product3.jpg',
            'description' => 'Aluminiowe felgi 16" - nowoczesny design, wysoka jakość wykonania.',
            'stock' => 50
        ],
        [
            'name' => 'Zestaw felg do samochodu',
            'price' => 599.99,
            'image' => '/public/img/products/product4.jpg',
            'description' => 'Zestaw felg premium 18" - stylowe i wytrzymałe, do samochodów klasy wyższej.',
            'stock' => 30
        ],
        [
            'name' => 'Klocki hamulcowe do samochodu',
            'price' => 299.99,
            'image' => '/public/img/products/product5.jpg',
            'description' => 'Klocki hamulcowe o wysokiej skuteczności, kompatybilne z większością modeli aut osobowych.',
            'stock' => 100
        ],
        [
            'name' => 'Zaciski hamulcowe do samochodu',
            'price' => 499.99,
            'image' => '/public/img/products/product6.jpg',
            'description' => 'Wysokiej jakości zaciski hamulcowe – lepsza kontrola i bezpieczeństwo podczas hamowania.',
            'stock' => 40
        ],
        [
            'name' => 'Zestaw felg do samochodu',
            'price' => 299.99,
            'image' => '/public/img/products/product7.jpg',
            'description' => 'Solidny zestaw felg 15", idealny do codziennej jazdy miejskiej.',
            'stock' => 60
        ],
        [
            'name' => 'Reflektor samochodowy',
            'price' => 899.99,
            'image' => '/public/img/products/product8.jpg',
            'description' => 'LED-owy reflektor samochodowy o wysokiej jasności i trwałości, homologowany na drogi publiczne.',
            'stock' => 20
        ],
    ];

    public function run(): void
    {
        $repository = new ProductRepository();

        foreach ($this->products as $data) {
            $product = Product::fromArray([
                Product::NAME => $data['name'],
                Product::DESCRIPTION => $data['description'],
                Product::IMAGE_URL => $data['image'],
                Product::PRICE => $data['price'],
                Product::STOCK => $data['stock'],
            ]);

            $repository->create($product);
        }
    }
}
