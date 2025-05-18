<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS activity_logs (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id CHAR(36),
        action VARCHAR(255) NOT NULL,
        metadata JSON,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    );
");
