<?php

namespace App\Http\Middlewares;

// External dependencies
use DateTime;

use App\Repositories\UserRepository;
use App\Repositories\AuthTokenRepository;

class AuthTokenMiddleware
{
    private UserRepository $userRepository;
    private AuthTokenRepository $authTokenRepository;

    public function __construct(UserRepository $userRepository, AuthTokenRepository $authTokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->authTokenRepository = $authTokenRepository;
    }

    public function handle()
    {
        session_start();

        // If user is already logged in, do nothing
        if (!empty($_SESSION['user'])) return;

        // If the remember_me cookie is not set, do nothing
        if (empty($_COOKIE['remember_me'])) return;

        // Parse the cookie value
        [$selector, $validator] = explode(':', $_COOKIE['remember_me']);

        // Get the token from the database
        $token = $this->authTokenRepository->findBySelector($selector);

        if (!$token || new DateTime() > new DateTime($token['expires_at'])) {
            // Token not found or expired -> delete the cookie
            setcookie('remember_me', '', time() - 3600, '/');
            return;
        }

        // Sprawdź poprawność validatora
        $hashedValidator = hash('sha256', $validator);
        if (!hash_equals($token['hashed_validator'], $hashedValidator)) {
            // Validator mismatch -> delete the token from the database and the cookie
            $this->authTokenRepository->deleteByUserId($token['user_id']);
            setcookie('remember_me', '', time() - 3600, '/');
            return;
        }

        // If everything is valid, log the user in
        $user = $this->userRepository->findById($token['user_id']);
        if ($user) $_SESSION['user'] = $user;
    }
}
