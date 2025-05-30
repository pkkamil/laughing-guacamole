<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected string $table = User::TABLE_NAME;
    protected string $modelClass = User::class;

    public function getUsingEmail(string $email): ?User
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data ? $this->mapToModel($data) : null;
    }

    public function create(User $user): void
    {
        $this->transaction(function (self $repo) use ($user) {
            $stmt = $repo->database->prepare("
            INSERT INTO {$repo->table} (id, email, password, first_name, last_name, role)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $user->generateUuid(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getRole()
            ]);
        });
    }

    public function update(string $id, User $user): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                email = ?,
                password = ?,
                first_name = ?,
                last_name = ?,
                role = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getRole(),
            $id
        ]);
    }
}
