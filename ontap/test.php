
<?php
require_once __DIR__ . '/common/auth_check.php';
require_once __DIR__ . '/common/dbConnect.php';

// Mặc định ngưỡng số lượng là 3
$rawMaxQty = $_GET['max_qty'] ?? '3';
$maxQtyInput = is_string($rawMaxQty)
    ? trim($rawMaxQty)
    : '';

$error = '';
$products = [];

// Kiểm tra số nguyên trong khoảng [0, 100]
$maxQty = filter_var(
    $maxQtyInput,
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 0,
            'max_range' => 100
        ]
    ]
);

if ($maxQty === false) {
    $error = 'Ngưỡng số lượng phải là số nguyên từ 0 đến 100.';
} else {
    // Chỉ truy vấn khi dữ liệu hợp lệ
    $sql = "SELECT id, name, price, quantity
            FROM products
            WHERE quantity <= ?
            ORDER BY quantity ASC, id ASC";

    $stmt = $conn->prepare($sql);

    // i = integer
    $stmt->bind_param('i', $maxQty);

    // Thực hiện truy vấn
    $stmt->execute();

    // Lấy danh sách sản phẩm
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}

include __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm sắp hết hàng</h2>

<form method="GET" action="">
    <label for="max_qty">
        Số lượng tồn kho tối đa:
    </label>

    <input
        type="text"
        id="max_qty"
        name="max_qty"
        inputmode="numeric"
        value="<?= htmlspecialchars(
            $maxQtyInput,
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <button type="submit">Lọc sản phẩm</button>
</form>

<?php if ($error !== ''): ?>

    <p style="color: red;">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>

<?php elseif (empty($products)): ?>

    <p>Không có sản phẩm phù hợp</p>

<?php else: ?>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= (int)$p['id'] ?></td>

                    <td>
                        <?= htmlspecialchars(
                            $p['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= number_format(
                            $p['price'],
                            0,
                            ',',
                            '.'
                        ) ?> VNĐ
                    </td>

                    <td><?= (int)$p['quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php include __DIR__ . '/view/footer.php'; ?>
