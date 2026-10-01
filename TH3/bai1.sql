CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

-- Tạo bảng cart_items 
CREATE TABLE IF NOT EXISTS cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL
);

-- Them san pham vao bang cart_items
INSERT IGNORE INTO cart_items (name, price, quantity)
VALUES
    ('Laptop ASUS Vivobook 16', 15990000.00, 1),
    ('Chuột Logitech MX Master 3S', 2490000.00, 3),
    ('Bàn phím cơ Keychron K2', 2190000.00, 2),
    ('Tai nghe Bluetooth Sony WH-CH520', 1290000.00, 4),
    ('USB Kingston 64GB', 180000.00, 8),
    ('Cáp sạc nhanh Type-C 100W', 350000.00, 6),
    ('Kính cường lực iPhone 15', 120000.00, 10),
    ('Ốp lưng chống sốc iPhone', 250000.00, 5),
    ('Pin sạc dự phòng Xiaomi 20000mAh', 650000.00, 2),
    ('Balo laptop chống nước', 650000.00, 3),
    ('Áo thun cotton basic', 180000.00, 7),
    ('Áo sơ mi trắng công sở nam', 350000.00, 4),
    ('Áo hoodie unisex', 550000.00, 2),
    ('Quần jean nam slim fit', 600000.00, 3),
    ('Dép quai ngang Adidas', 450000.00, 6),
    ('Sổ tay da A5', 120000.00, 10),
    ('Bút bi Thiên Long hộp 20 cái', 85000.00, 12),
    ('Giấy in A4 Double A 500 tờ', 95000.00, 15),
    ('Kẹp giấy văn phòng 100 cái', 35000.00, 20),
    ('Bình giữ nhiệt inox 500ml', 250000.00, 4),
    ('Đèn bàn học LED chống cận', 350000.00, 2),
    ('Ổ cắm điện thông minh Wifi', 450000.00, 5),
    ('Bình nước thể thao 1 lít', 180000.00, 8),
    ('Dây kháng lực tập gym', 150000.00, 6),
    ('Găng tay tập gym', 250000.00, 3),
    ('Khẩu trang y tế hộp 50 cái', 60000.00, 10),
    ('Nước rửa tay khô 500ml', 75000.00, 7),
    ('Kem chống nắng SPF50', 280000.00, 4);
    
-- Hien thi toan bo san pham 
SELECT *
FROM cart_items;

-- Hiển thị sản phẩm có số lượng lớn hơn 5 
SELECT *
FROM cart_items
WHERE quantity > 5;

-- Sắp xếp sản phẩm theo giá giảm dần 
SELECT *
FROM cart_items
ORDER BY price DESC; 

-- Cập nhật giá của một sản phẩm 
UPDATE cart_items 
SET price = 70560.00
WHERE name = 'Áo hoodie unisex';

-- Cập nhật số lượng của một sản phẩm
UPDATE cart_items 
SET quantity = 7
WHERE name = 'Áo hoodie unisex';

-- Xóa một sản phẩm khỏi giỏ hàng
DELETE FROM cart_items 
WHERE id = 25;

-- Hiển thị tên sản phẩm, giá, số lượng và thành tiền (price × quantity) 
SELECT name, price, quantity, price * quantity as thanh_tien
FROM cart_items;

-- Tính tổng tiền của toàn bộ giỏ hàng 
SELECT SUM(price * quantity) as tong_tien 
FROM cart_items;