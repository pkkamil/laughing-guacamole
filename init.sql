-- Users table
CREATE TABLE IF NOT EXISTS users (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Products table
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

-- Function for available product count
DELIMITER //
CREATE FUNCTION count_available_products()
RETURNS INT
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM products WHERE stock > 0;
    RETURN total;
END;
//
DELIMITER ;

-- Carts table
CREATE TABLE IF NOT EXISTS carts (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id CHAR(36),
    status VARCHAR(50) DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Cart items table
CREATE TABLE IF NOT EXISTS cart_items (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cart_id CHAR(36),
    product_id CHAR(36),
    quantity INT NOT NULL CHECK (quantity > 0),
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT NOT NULL
);

-- Activity logs table
CREATE TABLE IF NOT EXISTS activity_logs (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id CHAR(36),
    action VARCHAR(255) NOT NULL,
    metadata JSON,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Auth tokens table
CREATE TABLE IF NOT EXISTS auth_tokens (
    id CHAR(36) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id CHAR(36) NOT NULL,
    selector VARCHAR(255) NOT NULL,
    hashed_validator VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL
);

-- Seed users
INSERT INTO users (id, email, password, first_name, last_name, role) VALUES
(UUID(), 'jan.kowalski@example.com', '$2b$12$FueAUU5sIeqHdqc0qL2VHu22f9a4RZ1HtusXQdunxXvLlw9/Q.vda', 'Jan', 'Kowalski', 'user'),
(UUID(), 'anna.nowak@example.com', '$2b$12$gV5X69LqBjXjUP54XILixOnnWcpYDZJEnGZqJ0cCibvf95RqKRKv.', 'Anna', 'Nowak', 'user'),
(UUID(), 'admin@example.com', '$2b$12$DJNs8jq//R2KAP7BmJIcyujeSS2dnKNvdWKq7XN9ZPO6lqnWq3u2W', 'Admin', 'User', 'admin');

-- Seed products
INSERT INTO products (id, name, description, image_url, price, stock) VALUES
(UUID(), 'Kierownica samochodowa', 'Ergonomiczna kierownica samochodowa, idealna do tuningu wnętrza auta.', '/public/img/products/product1.jpg', 99.99, 25),
(UUID(), 'Opony BRIDGESTONE Blizzak 205/55R16', 'Zimowe opony BRIDGESTONE Blizzak zapewniające doskonałą przyczepność na śniegu i lodzie.', '/public/img/products/product2.jpg', 360.00, 80),
(UUID(), 'Zestaw felg do samochodu', 'Aluminiowe felgi 16" - nowoczesny design, wysoka jakość wykonania.', '/public/img/products/product3.jpg', 299.99, 50),
(UUID(), 'Zestaw felg do samochodu', 'Zestaw felg premium 18" - stylowe i wytrzymałe, do samochodów klasy wyższej.', '/public/img/products/product4.jpg', 599.99, 30),
(UUID(), 'Klocki hamulcowe do samochodu', 'Klocki hamulcowe o wysokiej skuteczności, kompatybilne z większością modeli aut osobowych.', '/public/img/products/product5.jpg', 299.99, 100),
(UUID(), 'Zaciski hamulcowe do samochodu', 'Wysokiej jakości zaciski hamulcowe – lepsza kontrola i bezpieczeństwo podczas hamowania.', '/public/img/products/product6.jpg', 499.99, 40),
(UUID(), 'Zestaw felg do samochodu', 'Solidny zestaw felg 15", idealny do codziennej jazdy miejskiej.', '/public/img/products/product7.jpg', 299.99, 60),
(UUID(), 'Reflektor samochodowy', 'LED-owy reflektor samochodowy o wysokiej jasności i trwałości, homologowany na drogi publiczne.', '/public/img/products/product8.jpg', 899.99, 20);
