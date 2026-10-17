<?php
require_once 'common/auth_check.php';
require_once 'model/product.php';
require_once 'common/csrf.php';
$products = getAllProducts();
include 'view/header.php';
?>

<h2>Danh sách sản phẩm</h2>

<p>Xin chào, <?php echo htmlspecialchars($_SESSION['username']) ?>!</p>
<form action="logout.php" method="POST" class="inline-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
    <button type="submit" class="btn">Đăng xuất</button>
</form>

<a href="product_add.php" class="btn">Thêm sản phẩm mới</a>
<table>
    <tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Chức năng</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['name']); ?></td>
        <td><?php echo number_format($p['price'], 0, ',', '.'); ?> VNĐ</td>
        <td><?php echo $p['quantity']; ?></td>
        <td>
            <form action="product_edit.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($p['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" style="background:none;border:none;color:red;text-decoration:underline;cursor:pointer;">[Sửa]</button>
            </form>
            <!-- Form ẩn để gọi xóa bằng POST kèm Token -->
            <form action="product_delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Xóa sản phẩm này?');">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($p['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" style="background:none;border:none;color:red;text-decoration:underline;cursor:pointer;">[Xóa]</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'view/footer.php'; ?>