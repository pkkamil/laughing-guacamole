<?php

namespace App\Repositories\Schemes;

// External dependencies
use PDO;

use App\DB;
use App\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected PDO $database;
    protected string $table;
    protected string $modelClass;

    public function __construct()
    {
        $this->database = (new DB())->connect();
    }

    public function get(): array
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToModel'], $data);
    }

    public function findById(string $id): ?object
    {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToModel($data) : null;
    }

    public function delete(string $id): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
    }

    protected function mapToModel(array $data): object
    {
        $modelClass = $this->modelClass;
        if (!method_exists($modelClass, 'fromArray')) {
            throw new \RuntimeException("Class {$modelClass} must implement fromArray()");
        }

        return $modelClass::fromArray($data);
    }
}
