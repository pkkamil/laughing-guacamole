<?php

namespace App\Interfaces;

use App\Models\ActivityLog;

interface ActivityLogRepositoryInterface
{
    public function create(ActivityLog $log): void;
    public function update(ActivityLog $log): void;
    public function delete(ActivityLog $log): void;
}
