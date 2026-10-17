
-- Database: shopping_cart
-- Tai khoan mau: admin / 123456

CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Du lieu san pham mau
INSERT INTO products (name, price, quantity)
VALUES
('Laptop ASUS Vivobook 16', 15990000.00, 1),
('Chuột Logitech MX Master 3S', 2490000.00, 3),
('Bàn phím cơ Keychron K2', 2190000.00, 2),
('Tai nghe Bluetooth Sony WH-CH520', 1290000.00, 4),
('USB Kingston 64GB', 180000.00, 8);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tai khoan mau: admin / 123456
-- Password duoc ma hoa bang password_hash()
INSERT INTO users (username, password)
VALUES (
    'admin',
    '$2y$12$9WcTIw6DFookmTdlwFQmgO4QoFy9x91S5PewGBozUN5F5IPWny2Ou'
)
ON DUPLICATE KEY UPDATE
    password = VALUES(password);
