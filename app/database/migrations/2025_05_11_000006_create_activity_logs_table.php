<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS activity_logs (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT UNSIGNED,
        action VARCHAR(255) NOT NULL,
        metadata JSON,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    );
");
