-- CSDL cho bài thực hành PHP và Vue.js - TH8
CREATE DATABASE IF NOT EXISTS vuejs_api_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vuejs_api_db;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL,
    CONSTRAINT chk_products_price CHECK (price > 0),
    CONSTRAINT chk_products_stock CHECK (stock >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu theo đề bài.
-- Chạy file SQL một lần trên CSDL mới để tránh thêm trùng dữ liệu.
INSERT INTO products (name, price, stock) VALUES
    ('Bút bi', 5000, 20),
    ('Vở ô ly', 12000, 15),
    ('Thước kẻ', 8000, 0);
