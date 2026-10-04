-- Sử dụng lại database cũ hoặc tạo mới nếu cần
CREATE DATABASE IF NOT EXISTS movie_ticketing;
USE movie_ticketing;

-- ==========================================
-- 1. TẠO BẢNG MOVIES
-- ==========================================
CREATE TABLE IF NOT EXISTS movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL UNIQUE,
    price DECIMAL(12,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

-- ==========================================
-- 2. THỰC HIỆN CÁC YÊU CẦU
-- ==========================================

-- 2.1. Thêm ít nhất 5 bộ phim
INSERT INTO movies (title, price, total_seats, available_seats)
VALUES 
    ('Lật Mặt 7', 120000.00, 200, 50),
    ('Mai', 150000.00, 250, 10),
    ('Kung Fu Panda 4', 90000.00, 150, 100),
    ('Dune: Hành Tinh Cát - Phần 2', 180000.00, 300, 20),
    ('Godzilla x Kong', 110000.00, 200, 60);

-- 2.2. Hiển thị toàn bộ danh sách phim
SELECT * 
FROM movies;

-- 2.3. Hiển thị phim có giá vé lớn hơn 100000
SELECT * 
FROM movies 
WHERE price > 100000;

-- 2.4. Hiển thị phim còn nhiều hơn 50 ghế
SELECT * 
FROM movies 
WHERE available_seats > 50;

-- 2.5. Sắp xếp phim theo giá vé giảm dần
SELECT * 
FROM movies 
ORDER BY price DESC;

-- 2.6. Cập nhật số ghế còn lại của một phim (Ví dụ có 5 người mua vé Mai)
UPDATE movies 
SET available_seats = available_seats - 5 
WHERE title = 'Mai';

-- 2.7. Xóa một phim (Ví dụ xóa Kung Fu Panda 4)
DELETE FROM movies 
WHERE title = 'Kung Fu Panda 4';

-- 2.8. Hiển thị số vé đã bán của từng phim
SELECT 
    title, 
    total_seats, 
    available_seats, 
    (total_seats - available_seats) AS ve_da_ban
FROM movies;

-- 2.9. Tính doanh thu của từng phim
SELECT 
    title, 
    (total_seats - available_seats) AS ve_da_ban,
    price,
    ((total_seats - available_seats) * price) AS doanh_thu
FROM movies;

-- 2.10. Tính tổng doanh thu của tất cả các phim
-- Sử dụng hàm SUM để tính tổng của phép nhân
SELECT SUM((total_seats - available_seats) * price) AS tong_doanh_thu_tat_ca
FROM movies;

-- 2.11. Tìm phim có số vé bán ra nhiều nhất (Sử dụng MAX)
SELECT 
    title, 
    (total_seats - available_seats) AS ve_da_ban
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats) 
    FROM movies
);