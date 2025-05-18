<?php

namespace App\Database\Seeders;

use App\Models\User;
use App\Repositories\UserRepository;

class UserSeeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'jan.kowalski@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'role' => User::ROLE_USER,
            ],
            [
                'email' => 'anna.nowak@example.com',
                'password' => password_hash('secret456', PASSWORD_DEFAULT),
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'role' => User::ROLE_USER,
            ],
            [
                'email' => 'admin@example.com',
                'password' => password_hash('adminpass', PASSWORD_DEFAULT),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => User::ROLE_ADMIN,
            ],
        ];

        $repository = new UserRepository();

        foreach ($users as $data) {
            $user = User::fromArray([
                User::EMAIL => $data['email'],
                User::PASSWORD => $data['password'],
                User::FIRST_NAME => $data['first_name'],
                User::LAST_NAME => $data['last_name'],
                User::ROLE => $data['role'],
            ]);

            $repository->create($user);
        }
    }
}
