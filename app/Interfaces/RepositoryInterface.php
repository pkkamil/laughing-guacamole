<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function findById(string $id): ?object;
    public function get(): array;
    public function delete(string $id): void;
}
