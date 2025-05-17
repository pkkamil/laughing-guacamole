<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUsingEmail(string $email): ?User;
    public function create(User $user): void;
    public function update(User $user): void;
    public function delete(User $user): void;
}
