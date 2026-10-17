<?php
require_once 'common/auth_check.php';
require_once 'common/csrf.php';
require_once 'model/product.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    verifyCsrf()

    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Sửa lỗi kiểm tra dữ liệu
    if ($name === "") {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (mb_strlen($str, 'UTF-8') > 100){
        $error = "Tên sản phẩm dài quá 100 ký tự.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
        // Lọc chuẩn xác số nguyên (integer), tránh trường hợp số thập phân như 1.5
        $error = "Số lượng phải là số nguyên lớn hơn hoặc bằng 0.";
    } else {
        if (addProduct($name, $price, $quantity)) {
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Đã xảy ra lỗi khi lưu vào cơ sở dữ liệu.";
        }
    }
}

include 'view/header.php';
?>
<h2>Thêm sản phẩm</h2>
<?php if ($error) echo "<p class='error'>$error</p>"; ?>
<form method="POST" action="">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"
    >
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
    </p>
    <p>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
    </p>
    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : ''; ?>">
    </p>
    <button type="submit" class="btn">Lưu sản phẩm</button>
    <a href="product_list.php" class="btn">Hủy</a>
</form>
<?php include 'view/footer.php'; ?>