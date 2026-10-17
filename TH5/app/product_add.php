
<?php
require_once 'common/auth_check.php';
require_once 'common/csrf.php';
require_once 'model/product.php';

$error = '';

$name = '';
$price = '';
$quantity = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $rawName = $_POST['name'] ?? '';
    $rawPrice = $_POST['price'] ?? '';
    $rawQuantity = $_POST['quantity'] ?? '';

    $name = is_string($rawName) ? trim($rawName) : '';
    $price = is_string($rawPrice) ? trim($rawPrice) : '';
    $quantity = is_string($rawQuantity)
        ? trim($rawQuantity)
        : '';

    $validQuantity = filter_var(
        $quantity,
        FILTER_VALIDATE_INT
    );

    if ($name === '') {
        $error = 'Tên sản phẩm không được rỗng.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $error = 'Tên sản phẩm không được quá 100 ký tự.';
    } elseif (
        !is_numeric($price) ||
        !is_finite((float) $price) ||
        (float) $price <= 0 ||
        (float) $price > 99999999.99 ||
        round((float) $price, 2) <= 0
    ) {
        $error = 'Giá phải lớn hơn 0 và không vượt quá 99999999.99.';
    } elseif (
        $validQuantity === false ||
        $validQuantity < 0 ||
        $validQuantity > 2147483647
    ) {
        $error = 'Số lượng phải là số nguyên từ 0 đến 2147483647.';
    } else {
        $validPrice = round((float) $price, 2);

        if (addProduct($name, $validPrice, $validQuantity)) {
            header('Location: product_list.php');
            exit();
        }

        $error = 'Đã xảy ra lỗi khi lưu vào cơ sở dữ liệu.';
    }
}

include 'view/header.php';
?>

<h2>Thêm sản phẩm</h2>

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
        <label for="name">Tên sản phẩm:</label><br>
        <input
            type="text"
            id="name"
            name="name"
            required
            maxlength="100"
            value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
        >
    </p>

    <p>
        <label for="price">Giá:</label><br>
        <input
            type="number"
            id="price"
            name="price"
            step="0.01"
            min="0.01"
            max="99999999.99"
            required
            value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>"
        >
    </p>

    <p>
        <label for="quantity">Số lượng:</label><br>
        <input
            type="number"
            id="quantity"
            name="quantity"
            step="1"
            min="0"
            max="2147483647"
            required
            value="<?= htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8') ?>"
        >
    </p>

    <button type="submit" class="btn">Lưu sản phẩm</button>
    <a href="product_list.php" class="btn">Hủy</a>
</form>

<?php include 'view/footer.php'; ?>
