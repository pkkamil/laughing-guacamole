<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class ActivityLog extends MysqlModel
{
    private ?string $userId;
    private string $action;
    private ?array $metadata;

    public const TABLE_NAME = 'activity_logs';

    public const USER_ID = 'userId';
    public const ACTION = 'action';
    public const METADATA = 'metadata';

    public function getUserId(): ?string
    {
        return $this->{self::USER_ID};
    }

    public function setUserId(?string $userId): void
    {
        $this->{self::USER_ID} = $userId;
    }

    public function getAction(): string
    {
        return $this->{self::ACTION};
    }

    public function setAction(string $action): void
    {
        $this->{self::ACTION} = $action;
    }

    public function getMetadata(): ?array
    {
        return $this->{self::METADATA};
    }

    public function setMetadata(?array $metadata): void
    {
        $this->{self::METADATA} = $metadata;
    }

    public static function fromArray(array $data): static
    {
        $log = new static();
        $log->setId($data['id'] ?? '');
        $log->setCreatedAt($data['created_at'] ?? '');
        $log->setUserId(isset($data['user_id']) ? (int)$data['user_id'] : null);
        $log->setAction($data['action'] ?? '');

        if (isset($data['metadata']) && !empty($data['metadata'])) {
            $decoded = json_decode($data['metadata'], true);
            $log->setMetadata($decoded !== null ? $decoded : null);
        } else {
            $log->setMetadata(null);
        }

        return $log;
    }
}
