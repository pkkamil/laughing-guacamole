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
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (email, password, first_name, last_name)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName()
        ]);
    }

    public function update(User $user): void
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
            $user->getId()
        ]);
    }

    public function delete(User $user): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$user->getId()]);
    }
}
