<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('/auth/login');
        }

        // if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token'])) {
        //     // Nieprawidłowy token CSRF
        //     die('Błąd CSRF: nieprawidłowy token.');
        // }

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/projects");
    }

    public function register()
    {
        if (!$this->isPost()) return $this->render('/auth/register');

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        if ($password !== $confirmedPassword) return $this->render('register', ['messages' => ['Please provide proper password']]);

        //TODO try to use better hash function
        $user = new User($email, md5($password), $firstName, $lastName);

        $this->userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
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
