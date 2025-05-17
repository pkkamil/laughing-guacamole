<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS auth_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT NOT NULL,
        selector VARCHAR(255) NOT NULL,
        hashed_validator VARCHAR(255) NOT NULL,
        expires_at TIMESTAMP NOT NULL
    );
");
