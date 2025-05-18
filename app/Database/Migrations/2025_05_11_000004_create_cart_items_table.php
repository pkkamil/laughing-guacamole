<?php

$db->exec("
    CREATE TABLE IF NOT EXISTS cart_items (
        id CHAR(36) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        cart_id CHAR(36),
        product_id CHAR(36),
        quantity INT NOT NULL CHECK (quantity > 0),
        FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id)
    );
");
