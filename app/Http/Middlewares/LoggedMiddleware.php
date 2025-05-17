<?php

namespace App\Http\Middlewares;

class LoggedMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}
