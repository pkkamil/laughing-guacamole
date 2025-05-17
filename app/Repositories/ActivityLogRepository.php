<?php

namespace App\Repositories;

use App\Interfaces\ActivityLogRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\ActivityLog;

class ActivityLogRepository extends Repository implements ActivityLogRepositoryInterface
{
    protected string $table = ActivityLog::TABLE_NAME;
    protected string $modelClass = ActivityLog::class;

    public function create(ActivityLog $log): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (user_id, action, metadata, created_at)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $log->getUserId(),
            $log->getAction(),
            $log->getMetadata() ? json_encode($log->getMetadata()) : null,
            $log->getCreatedAt()
        ]);
    }

    public function update(ActivityLog $log): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                user_id = ?,
                action = ?,
                metadata = ?,
                created_at = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $log->getUserId(),
            $log->getAction(),
            $log->getMetadata() ? json_encode($log->getMetadata()) : null,
            $log->getCreatedAt(),
            $log->getId()
        ]);
    }

    public function delete(ActivityLog $log): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$log->getId()]);
    }
}
