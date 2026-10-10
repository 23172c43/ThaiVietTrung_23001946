<?php
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
            <a href="product_delete.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">[Xóa]</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include 'view/footer.php'; ?>