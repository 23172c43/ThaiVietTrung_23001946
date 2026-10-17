<?php
require_once 'common/auth_check.php';
require_once 'common/csrf.php';
require_once 'model/product.php';

$error = '';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    http_response_code(400);
    exit('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

if (!$product) {
    http_response_code(404);
    exit('Sản phẩm không tồn tại.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $rawName = $_POST['name'] ?? '';
    $rawPrice = $_POST['price'] ?? '';
    $rawQuantity = $_POST['quantity'] ?? '';

    $name = is_string($rawName) ? trim($rawName) : '';
    $price = is_string($rawPrice) ? $rawPrice : '';
    $quantity = filter_var(
        $rawQuantity,
        FILTER_VALIDATE_INT
    );

    if ($name === '') {
        $error = 'Tên sản phẩm không được rỗng.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $error = 'Tên sản phẩm dài quá 100 ký tự.';
    } elseif (
        !is_numeric($price) ||
        !is_finite((float) $price) ||
        (float) $price <= 0 ||
        (float) $price > 99999999.99
    ) {
        $error = 'Giá không hợp lệ.';
    } elseif (
        $quantity === false ||
        $quantity < 0 ||
        $quantity > 2147483647
    ) {
        $error = 'Số lượng phải là số nguyên không âm hợp lệ.';
    } else {
        if (updateProduct(
            $id,
            $name,
            round((float) $price, 2),
            $quantity
        )) {
            header('Location: product_list.php');
            exit();
        }

        $error = 'Đã xảy ra lỗi khi cập nhật dữ liệu.';
    }
}

include 'view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if ($error): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"
    >

    <p>
        <label>Tên sản phẩm:</label><br>
        <input
            type="text"
            name="name"
            required
            maxlength="100"
            value="<?= htmlspecialchars(
                is_string($_POST['name'] ?? null)
                    ? $_POST['name']
                    : $product['name'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </p>

    <p>
        <label>Giá:</label><br>
        <input
            type="number"
            name="price"
            step="0.01"
            min="0.01"
            required
            value="<?= htmlspecialchars(
                is_string($_POST['price'] ?? null)
                    ? $_POST['price']
                    : (string) $product['price'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </p>

    <p>
        <label>Số lượng:</label><br>
        <input
            type="number"
            name="quantity"
            min="0"
            step="1"
            required
            value="<?= htmlspecialchars(
                is_string($_POST['quantity'] ?? null)
                    ? $_POST['quantity']
                    : (string) $product['quantity'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </p>

    <button type="submit" class="btn">
        Cập nhật
    </button>

    <a href="product_list.php" class="btn">Hủy</a>
</form>

<?php include 'view/footer.php'; ?>
