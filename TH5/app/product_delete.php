
<?php
require_once 'common/auth_check.php';
require_once 'common/csrf.php';
require_once 'model/product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

verifyCsrf();

$id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT
);

if ($id === false || $id === null || $id <= 0) {
    http_response_code(400);
    exit('ID không hợp lệ.');
}

$product = getProductById($id);

if (!$product) {
    http_response_code(404);
    exit('Sản phẩm không tồn tại.');
}

if (deleteProduct($id)) {
    header('Location: product_list.php');
    exit();
}

http_response_code(500);
exit('Không thể xóa sản phẩm.');
?>