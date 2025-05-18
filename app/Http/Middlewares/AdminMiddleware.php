<?php

namespace App\Http\Middlewares;

use App\Models\User;

class AdminMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']->{User::ROLE} !== User::ROLE_ADMIN) {
            header('Location: /');
            exit;
        }
    }
}
