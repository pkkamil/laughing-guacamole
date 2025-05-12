<?php

class AuthMiddleware
{
    private $userRepository;
    private $authTokenRepository;

    public function __construct($userRepository, $authTokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->authTokenRepository = $authTokenRepository;
    }

    public function handle()
    {
        session_start();

        // Jeśli użytkownik już jest zalogowany — nic nie rób
        if (!empty($_SESSION['user'])) {
            return;
        }

        // Jeśli nie ma ciasteczka — nic nie rób
        if (empty($_COOKIE['remember_me'])) {
            return;
        }

        // Parsuj selector i validator
        [$selector, $validator] = explode(':', $_COOKIE['remember_me']);

        // Pobierz token z bazy
        $token = $this->authTokenRepository->findBySelector($selector);

        if (!$token || new DateTime() > new DateTime($token['expires_at'])) {
            // Token nie istnieje lub wygasł – usuń ciasteczko
            setcookie('remember_me', '', time() - 3600, '/');
            return;
        }

        // Sprawdź poprawność validatora
        $hashedValidator = hash('sha256', $validator);
        if (!hash_equals($token['hashed_validator'], $hashedValidator)) {
            // Próba ataku — usuń wszystkie tokeny tego użytkownika
            $this->authTokenRepository->deleteByUserId($token['user_id']);
            setcookie('remember_me', '', time() - 3600, '/');
            return;
        }

        // Wszystko ok — zaloguj użytkownika
        $user = $this->userRepository->findById($token['user_id']);
        if ($user) {
            $_SESSION['user'] = $user;
        }
    }
}
