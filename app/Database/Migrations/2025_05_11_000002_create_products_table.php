<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS products (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        image_url TEXT,
        price DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL DEFAULT 0
    );
");

$db->exec("
    CREATE FUNCTION count_available_products()
    RETURNS INT
    BEGIN
        DECLARE total INT;
        SELECT COUNT(*) INTO total FROM products WHERE stock > 0;
        RETURN total;
    END;
");
