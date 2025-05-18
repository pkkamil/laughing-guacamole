<?php

namespace App\Http\Modules\Auth;

// External dependencies
use DateTime;

use App\Http\Controllers\BaseController;

use App\Http\Modules\Auth\Requests\{
    LoginRequest,
    RegisterRequest,
    ResetRequest,
};
use App\Models\User;

use App\Repositories\{
    AuthTokenRepository,
    ProductRepository,
    UserRepository
};

use App\Http\Modules\Auth\Resources\UserResource;
use App\Models\AuthToken;

class Controller extends BaseController
{
    private UserRepository $userRepository;
    private AuthTokenRepository $authTokenRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->authTokenRepository = new AuthTokenRepository();
    }

    public function login()
    {
        if (!$this->isPost()) return $this->render('/auth/forms/login');

        $request = new LoginRequest($_POST);

        if ($request->fails()) {
            $_SESSION['errors'] = $request->errors();
            $_SESSION['old'] = $_POST;
            return $this->render('/auth/forms/login');
        }

        $data = $request->validated();

        $user = $this->userRepository->getUsingEmail($data['email']);

        $errors = [];
        $old = $_POST;

        if (!$user || !password_verify($data['password'], $user->getPassword())) {
            $errors['password'] = 'Nieprawidłowe hasło.';
        }

        if (empty($errors)) {
            $_SESSION['user'] = $user;

            if (!empty($data['remember'])) {
                // Clear old tokens
                $this->authTokenRepository->deleteByUserId($user->getId());

                // Generate selector + validator
                $selector = bin2hex(random_bytes(8));
                $validator = bin2hex(random_bytes(32));
                $hashedValidator = hash('sha256', $validator);
                $expires = (new DateTime('+30 days'));

                // Create auth token
                $authToken = AuthToken::fromArray([
                    AuthToken::USER_ID => $user->getId(),
                    AuthToken::SELECTOR => $selector,
                    AuthToken::HASHED_VALIDATOR => $hashedValidator,
                    AuthToken::EXPIRES_AT => $expires->format('Y-m-d H:i:s')
                ]);

                // Save token to the database
                $this->authTokenRepository->create($authToken);

                // Set cookie
                $cookieValue = "$selector:$validator";
                setcookie('remember_me', $cookieValue, time() + 3600 * 24 * 30, '/', '', false, true); // HTTPOnly
            }

            header('Location: /account');
        }

        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;

        return $this->render('/auth/forms/login');
    }

    public function register()
    {
        if (!$this->isPost()) return $this->render('/auth/forms/register');

        $request = new RegisterRequest($_POST);

        if ($request->fails()) {
            $_SESSION['errors'] = $request->errors();
            $_SESSION['old'] = $_POST;
            return $this->render('/auth/forms/register');
        }

        $data = $request->validated();

        $existingUser = $this->userRepository->getUsingEmail($data['email']);
        if ($existingUser) {
            $_SESSION['errors'] = ['email' => 'Użytkownik o tym adresie e-mail już istnieje.'];
            $_SESSION['old'] = $_POST;
            return $this->render('/auth/forms/register');
        }

        $user = User::fromArray([
            User::EMAIL => $data['email'],
            User::PASSWORD => password_hash($data['password'], PASSWORD_DEFAULT),
            User::FIRST_NAME => $data['firstName'],
            User::LAST_NAME => $data['lastName'],
        ]);

        $this->userRepository->create($user);

        return $this->render('/auth/forms/login', [
            'messages' => ['Rejestracja zakończona sukcesem. Możesz się teraz zalogować.']
        ]);
    }

    public function reset()
    {
        if (!$this->isPost()) return $this->render('/auth/forms/reset');

        $request = new ResetRequest($_POST);

        if ($request->fails()) {
            $_SESSION['errors'] = $request->errors();
            $_SESSION['old'] = $_POST;
            return $this->render('/auth/forms/reset');
        }

        $data = $request->validated();
        $user = $this->userRepository->getUsingEmail($data['email']);

        if (!$user) {
            $_SESSION['errors'] = ['email' => 'Nie znaleziono użytkownika o tym adresie e-mail.'];
            $_SESSION['old'] = $_POST;
            return $this->render('/auth/forms/reset');
        }

        // Generate reset token
        $token = bin2hex(random_bytes(16));
        $expires = (new DateTime('+1 hour'));

        // Create auth token
        $authToken = AuthToken::fromArray([
            AuthToken::USER_ID => $user->getId(),
            AuthToken::SELECTOR => $token,
            AuthToken::HASHED_VALIDATOR => hash('sha256', $token),
            AuthToken::EXPIRES_AT => $expires->format('Y-m-d H:i:s')
        ]);

        // Save token to the database
        $this->authTokenRepository->create($authToken);

        // Send email with reset link
        $resetLink = "https://example.com/reset?token=$token";
        $subject = "Resetowanie hasła";

        $message = "Kliknij w poniższy link, aby zresetować hasło: $resetLink";
        mail($data['email'], $subject, $message);

        return $this->render('/auth/forms/reset', [
            'messages' => ['Link do resetowania hasła został wysłany na podany adres e-mail.']
        ]);
    }

    public function logout()
    {
        // Clear session
        session_destroy();

        // Clear cookie
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/');
        }

        unset($_SESSION['user']);

        // Redirect to login page
        header('Location: /login');
        exit;
    }

    public function account()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->findById($_SESSION['user']->getId());

        return $this->render('/auth/account', [
            'user' => (new UserResource($user))->toArray(),
        ]);
    }

    public function admin()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->findById($_SESSION['user']->getId());

        $productRepository = new ProductRepository();
        $products = $productRepository->get();

        return $this->render('/auth/admin/index', [
            'user' => (new UserResource($user))->toArray(),
            'orders' => 0,
            'products' => count($products),
        ]);
    }

    public function settings()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->findById($_SESSION['user']->getId());

        return $this->render('/auth/admin/settings', [
            'user' => (new UserResource($user))->toArray(),
            'settings' => [
                'hero_image' => '/public/img/hero.jpg',
                'welcome_box_text' => 'Przeglądaj wspaniałe produkty',
                'welcome_box_button_text' => 'Przeglądaj',
            ],
        ]);
    }
}
