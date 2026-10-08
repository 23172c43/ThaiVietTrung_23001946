<?php
require_once 'model/product.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
} else {
    header("Location: product_list.php");
    exit();
}
?>