<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS carts (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        user_id CHAR(36),
        status VARCHAR(50) DEFAULT 'active',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    );
");
