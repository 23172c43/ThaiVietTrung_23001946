<?php
require_once 'model/product.php';
$error = "";

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID sản phẩm.");
}
$id = $_GET['id'];
$product = getProductById($id);

if (!$product) {
    die("Sản phẩm không tồn tại trong hệ thống.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Kiểm tra dữ liệu
    if (empty($name)) {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Số lượng phải lớn hơn hoặc bằng 0.";
    } else {
        if (updateProduct($id, $name, $price, $quantity)) {
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Đã xảy ra lỗi khi cập nhật dữ liệu.";
        }
    }
}

include 'view/header.php';
?>
<h2>Sửa sản phẩm</h2>
<?php if ($error) echo "<p class='error'>$error</p>"; ?>
<form method="POST" action="">
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($product['name']); ?>">
    </p>
    <p>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : htmlspecialchars($product['price']); ?>">
    </p>
    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : htmlspecialchars($product['quantity']); ?>">
    </p>
    <button type="submit" class="btn">Cập nhật</button>
    <a href="product_list.php" class="btn">Hủy</a>
</form>
<?php include 'view/footer.php'; ?>