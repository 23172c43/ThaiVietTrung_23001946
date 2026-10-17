<?php
require_once 'common/auth_check.php';
require_once 'common/csrf.php';
require_once 'model/product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

verifyCsrf();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Kiểm tra tính hợp lệ của CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Yêu cầu không hợp lệ (Lỗi bảo mật CSRF).");
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $product = getProductById($id);

        if ($product) {
            deleteProduct($id);
            header("Location: product_list.php");
            exit();
        } else {
            include 'view/header.php';
            echo "<h2 class='error'>Lỗi</h2><p>Sản phẩm này không tồn tại.</p><a href='product_list.php' class='btn'>Quay lại danh sách</a>";
            include 'view/footer.php';
            exit();
        }
    }
}

// Nếu không phải POST hoặc thiếu dữ liệu, đẩy về trang danh sách
header("Location: product_list.php");
exit();
?>