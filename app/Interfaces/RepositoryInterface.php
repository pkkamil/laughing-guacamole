<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function findById(string $id): ?object;
}
