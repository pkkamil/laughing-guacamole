<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS contacts (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        message TEXT NOT NULL
    );
");
