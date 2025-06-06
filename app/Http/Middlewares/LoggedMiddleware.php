<?php

namespace App\Http\Middlewares;

use App\Repositories\UserRepository;

class LoggedMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Check if the user exists in the database
        $userRepository = new UserRepository();
        $user = $userRepository->findById($_SESSION['user']->getId());

        if (!$user) {
            // Clear the session if the user does not exist
            session_destroy();
            unset($_SESSION['user']);

            header('Location: /login');
            exit;
        }
    }
}
