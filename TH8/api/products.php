<?php
require_once __DIR__ . '/../common/dbConnect.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$input = json_decode(file_get_contents('php://input'), true);

function validateInput($data) {
    $name = isset($data['name']) ? trim($data['name']) : '';
    $price = isset($data['price']) ? intval($data['price']) : 0;
    $stock = isset($data['stock']) ? intval($data['stock']) : -1;

    if (strlen($name) < 1 || strlen($name) > 100) {
        return ['valid' => false, 'message' => 'Tên sản phẩm phải từ 1 đến 100 ký tự.'];
    }
    if ($price <= 0) {
        return ['valid' => false, 'message' => 'Đơn giá phải là số nguyên lớn hơn 0.'];
    }
    if ($stock < 0) {
        return ['valid' => false, 'message' => 'Số lượng tồn không được âm.'];
    }

    return ['valid' => true, 'data' => ['name' => $name, 'price' => $price, 'stock' => $stock]];
}

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $products]);
        break;

    case 'POST':
        $val = validateInput($input);
        if (!$val['valid']) {
            echo json_encode(['success' => false, 'message' => $val['message']]);
            break;
        }
        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->execute([$val['data']['name'], $val['data']['price'], $val['data']['stock']]);
        echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm thành công.']);
        break;

    case 'PUT':
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm (id).']);
            break;
        }
        $val = validateInput($input);
        if (!$val['valid']) {
            echo json_encode(['success' => false, 'message' => $val['message']]);
            break;
        }
        
        $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $check->execute([$id]);
        if (!$check->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            break;
        }

        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$val['data']['name'], $val['data']['price'], $val['data']['stock'], $id]);
        echo json_encode(['success' => true, 'message' => 'Cập nhật sản phẩm thành công.']);
        break;

    case 'DELETE':
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm (id).']);
            break;
        }
        
        $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $check->execute([$id]);
        if (!$check->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            break;
        }

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công.']);
        break;
}
?>