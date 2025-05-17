<?php

namespace App\Models;

use InvalidArgumentException;

use App\Models\Schemes\MysqlModel;

class User extends MysqlModel
{
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $role;

    // Role constants
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    public const TABLE_NAME = 'users';
    // Table constants
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    public const ROLE = 'role';

    public function getEmail(): string
    {
        return $this->{self::EMAIL};
    }

    public function getPassword(): string
    {
        return $this->{self::PASSWORD};
    }

    public function getFirstName(): string
    {
        return $this->{self::FIRST_NAME};
    }

    public function setFirstName(string $firstName): void
    {
        $this->{self::FIRST_NAME} = $firstName;
    }

    public function getLastName(): string
    {
        return $this->{self::LAST_NAME};
    }

    public function setLastName(string $lastName): void
    {
        $this->{self::LAST_NAME} = $lastName;
    }

    public function getRole(): string
    {
        return $this->{self::ROLE};
    }

    public function setRole(string $role): void
    {
        if (!in_array($role, self::ROLES)) throw new InvalidArgumentException('Invalid role');
        $this->{self::ROLE} = $role;
    }

    public static function fromArray(array $data): static
    {
        $user = new static();
        $user->setId($data['id'] ?? '');
        $user->setCreatedAt($data['created_at'] ?? '');
        $user->setUpdatedAt($data['updated_at'] ?? '');
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->firstName = $data['first_name'];
        $user->lastName = $data['last_name'];
        $user->setRole($data['role'] ?? self::ROLE_USER);

        return $user;
    }
}
