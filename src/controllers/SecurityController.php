<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/AuthTokenRepository.php';

class SecurityController extends AppController
{
    private UserRepository $userRepository;
    private AuthTokenRepository $authTokenRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->authTokenRepository = new AuthTokenRepository();
    }

    // TODO: Add LoginRequest
    // TODO: Add DefaultResource

    public function login()
    {
        if (!$this->isPost()) return $this->render('/auth/login');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        $errors = [];
        $old = $_POST;

        if (!$user || !password_verify($password, $user->getPassword())) $errors['password'] = 'Nieprawidłowe hasło.';

        if (empty($errors)) {
            $_SESSION['user'] = $user;

            if (!empty($_POST['remember'])) {
                // Clear old tokens
                $this->authTokenRepository->deleteByUserId($user->getId());

                // Generate selector + validator
                $selector = bin2hex(random_bytes(8));
                $validator = bin2hex(random_bytes(32));
                $hashedValidator = hash('sha256', $validator);
                $expires = (new DateTime('+30 days'));

                // Save token to the database
                $this->authTokenRepository->create(
                    $user->getId(),
                    $selector,
                    $hashedValidator,
                    $expires
                );

                // Set cookie
                $cookieValue = "$selector:$validator";
                setcookie('remember_me', $cookieValue, time() + 3600 * 24 * 30, '/', '', false, true); // HTTPOnly
            }

            header('Location: /account');
            exit;
        }

        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;

        return $this->render('/auth/login');
    }

    public function register()
    {
        if (!$this->isPost()) return $this->render('/auth/register');

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        $errors = [];
        $old = $_POST;

        // Walidacja hasła
        if ($password !== $confirmedPassword) {
            $errors['password'] = 'Hasła muszą się zgadzać.';
        }

        // Sprawdzenie, czy e-mail już istnieje
        $existingUser = $this->userRepository->getUser($email);
        if ($existingUser) {
            $errors['email'] = 'Użytkownik o tym adresie e-mail już istnieje.';
        }

        // Walidacja danych
        if (empty($firstName)) $errors['firstName'] = 'Imię jest wymagane.';
        if (empty($lastName)) $errors['lastName'] = 'Nazwisko jest wymagane.';
        if (empty($email)) $errors['email'] = 'E-mail jest wymagany.';
        if (empty($password)) $errors['password'] = 'Hasło jest wymagane.';

        // Jeśli są błędy, zwróć formularz z błędami
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $old;
            return $this->render('/auth/register');
        }

        // Utworzenie nowego użytkownika
        $user = new User(
            email: $email,
            password: password_hash($password, PASSWORD_DEFAULT),
            firstName: $firstName,
            lastName: $lastName
        );

        // Dodanie użytkownika do bazy danych
        $this->userRepository->addUser($user);

        // Przekierowanie do logowania po zarejestrowaniu
        return $this->render('/auth/login', ['messages' => ['Rejestracja zakończona sukcesem. Możesz się teraz zalogować.']]);
    }

    public function reset()
    {
        if (!$this->isPost()) {
            return $this->render('/auth/passwords/reset');
        }

        // TODO: Implement password reset functionality
        // $email = $_POST['email'];
        // $password = md5($_POST['password']);

        // $user = $this->userRepository->getUser($email);

        // if (!$user) {
        //     return $this->render('login', ['messages' => ['User not found!']]);
        // }

        // if ($user->getEmail() !== $email) {
        //     return $this->render('login', ['messages' => ['User with this email not exist!']]);
        // }

        // if ($user->getPassword() !== $password) {
        //     return $this->render('login', ['messages' => ['Wrong password!']]);
        // }

        // $url = "http://$_SERVER[HTTP_HOST]";
        // header("Location: {$url}/projects");
    }
}
