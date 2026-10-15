-- ============================================================
-- Database: shopping_cart
-- Bảng: products (id, name, price, quantity)
-- Dữ liệu mẫu: 5 sản phẩm
-- Cách chạy: mysql -uroot < shopping_cart.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS shopping_cart
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id        INT            NOT NULL AUTO_INCREMENT,
    name      VARCHAR(100)   NOT NULL,
    price     DECIMAL(10,2)  NOT NULL,
    quantity  INT            NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Thêm tối thiểu 5 sản phẩm
INSERT INTO products (name, price, quantity) VALUES
('Laptop ASUS Vivobook 16',            15990000.00, 1),
('Chuột Logitech MX Master 3S',         2490000.00, 3),
('Bàn phím cơ Keychron K2',             2190000.00, 2),
('Tai nghe Bluetooth Sony WH-CH520',    1290000.00, 4),
('USB Kingston 64GB',                    180000.00, 8);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Thêm 1 tài khoản mẫu (username: admin, password: 123456 đã được mã hóa bằng password_hash)[cite: 1]
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');