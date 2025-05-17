<?php

namespace App\Http\Middlewares;

class AdminMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /');
            exit;
        }
    }
}
