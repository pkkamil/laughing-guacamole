<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS auth_tokens (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id CHAR(36) NOT NULL,
        selector VARCHAR(255) NOT NULL,
        hashed_validator VARCHAR(255) NOT NULL,
        expires_at TIMESTAMP NOT NULL
    );
");
