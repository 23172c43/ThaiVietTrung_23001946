<?php
$servername = "localhost";
$username = "root";
// Trên môi trường Ubuntu/Linux, tài khoản MySQL root thường có mật khẩu. 
// Hãy điền mật khẩu của bạn vào đây nếu có.
$password = ""; 
$dbname = "shopping_cart";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
} catch (Exception $e) {
    // Bắt lỗi và hiển thị ra màn hình thay vì văng lỗi 500
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>