<?php
// File này chỉ tạo kết nối PDO. Phần xử lý lỗi và trả JSON nằm trong api/products.php.

$host = 'localhost';
$dbname = 'vuejs_api_db';
$username = 'root';
$password = ''; // Thay đổi nếu MySQL trên máy bạn có mật khẩu.
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_STRINGIFY_FETCHES  => false,
];

$pdo = new PDO($dsn, $username, $password, $options);
