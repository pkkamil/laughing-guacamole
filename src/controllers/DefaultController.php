<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('homepage');
    }

    public function catalog()
    {
        $this->render('catalog');
    }

    public function contact()
    {
        $this->render('contact');
    }

    public function cart()
    {
        $this->render('cart');
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
