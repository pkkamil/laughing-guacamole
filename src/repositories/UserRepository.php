<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->prepare('
        SELECT * FROM users u WHERE email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) return null;

        // Tworzymy użytkownika bez id
        $userObj = new User(
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name']
        );

        $userObj->setId($user['id']);

        return $userObj;
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->prepare('
            INSERT INTO users (email, password, first_name, last_name)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName()
        ]);
    }
}
