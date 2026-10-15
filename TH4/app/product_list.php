<?php
// 1. Khởi tạo session và tạo CSRF token để bảo vệ form
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'model/product.php';
$products = getAllProducts();
include 'view/header.php';
?>
<h2>Danh sách sản phẩm</h2>
<a href="product_add.php" class="btn">Thêm sản phẩm mới</a>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['name']); ?></td>
        <td><?php echo number_format($p['price'], 2); ?> VNĐ</td>
        <td><?php echo $p['quantity']; ?></td>
        <td>
            <a href="product_edit.php?id=<?php echo $p['id']; ?>">[Sửa]</a>
            
            <!-- 2. Thay thế thẻ <a> bằng <form> sử dụng phương thức POST -->
            <form action="product_delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                <!-- Truyền ID sản phẩm -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($p['id']); ?>">
                
                <!-- Truyền CSRF Token để xác thực -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <!-- Nút submit được style lại để trông giống thẻ <a> -->
                <button type="submit" style="background: none; border: none; color: blue; text-decoration: underline; cursor: pointer; padding: 0; font: inherit;">[Xóa]</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include 'view/footer.php'; ?>