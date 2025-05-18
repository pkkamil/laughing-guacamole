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
            INSERT INTO {$this->table} (id, user_id, action, metadata)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $log->generateUuid(),
            $log->getUserId(),
            $log->getAction(),
            $log->getMetadata() ? json_encode($log->getMetadata()) : null,
        ]);
    }
}
