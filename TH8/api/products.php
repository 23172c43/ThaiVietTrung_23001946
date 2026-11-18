<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

/** Trả phản hồi JSON và kết thúc request. */
function respond(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

/** Đếm số ký tự Unicode; có phương án dự phòng nếu máy chưa bật mbstring. */
function unicodeLength(string $value): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($value, 'UTF-8');
    }

    $length = preg_match_all('/./us', $value);
    return ($length === false) ? -1 : $length;
}

/** Kiểm tra dữ liệu trước khi ghi vào MySQL. */
function validateProductInput($data): array
{
    if (!is_array($data)) {
        return [
            'valid' => false,
            'message' => 'Dữ liệu JSON phải là một đối tượng hợp lệ.'
        ];
    }

    $rawName = $data['name'] ?? null;
    if (!is_string($rawName)) {
        return [
            'valid' => false,
            'message' => 'Tên sản phẩm phải là chuỗi ký tự.'
        ];
    }

    $name = trim($rawName);
    $nameLength = unicodeLength($name);

    if ($nameLength < 1 || $nameLength > 100) {
        return [
            'valid' => false,
            'message' => 'Tên sản phẩm sau khi bỏ khoảng trắng phải từ 1 đến 100 ký tự.'
        ];
    }

    $price = $data['price'] ?? null;
    if (!is_int($price) || $price <= 0) {
        return [
            'valid' => false,
            'message' => 'Đơn giá phải là số nguyên lớn hơn 0.'
        ];
    }

    $stock = $data['stock'] ?? null;
    if (!is_int($stock) || $stock < 0) {
        return [
            'valid' => false,
            'message' => 'Số lượng tồn phải là số nguyên không âm.'
        ];
    }

    return [
        'valid' => true,
        'data' => [
            'name' => $name,
            'price' => $price,
            'stock' => $stock
        ]
    ];
}

/** Lấy và kiểm tra id trên URL. */
function getProductId(): int
{
    $rawId = $_GET['id'] ?? null;

    if (!is_scalar($rawId)) {
        respond([
            'success' => false,
            'message' => 'Vui lòng cung cấp mã sản phẩm (id) hợp lệ.'
        ], 400);
    }

    $id = filter_var($rawId, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    if ($id === false) {
        respond([
            'success' => false,
            'message' => 'Mã sản phẩm phải là số nguyên dương.'
        ], 400);
    }

    return (int) $id;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    require_once __DIR__ . '/../common/dbConnect.php';

    switch ($method) {
        case 'GET':
            $stmt = $pdo->query(
                'SELECT id, name, price, stock FROM products ORDER BY id ASC'
            );

            respond([
                'success' => true,
                'data' => $stmt->fetchAll()
            ]);

        case 'POST':
        case 'PUT':
            $rawBody = file_get_contents('php://input');
            $input = json_decode($rawBody, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($input)) {
                respond([
                    'success' => false,
                    'message' => 'JSON không hợp lệ hoặc không có dữ liệu gửi lên.'
                ], 400);
            }

            $validation = validateProductInput($input);
            if (!$validation['valid']) {
                respond([
                    'success' => false,
                    'message' => $validation['message']
                ], 400);
            }

            $product = $validation['data'];

            if ($method === 'POST') {
                $stmt = $pdo->prepare(
                    'INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)'
                );
                $stmt->execute([
                    ':name' => $product['name'],
                    ':price' => $product['price'],
                    ':stock' => $product['stock']
                ]);

                respond([
                    'success' => true,
                    'message' => 'Thêm sản phẩm thành công.',
                    'id' => (int) $pdo->lastInsertId()
                ], 201);
            }

            // PUT: cập nhật sản phẩm theo id trên URL.
            $id = getProductId();

            $check = $pdo->prepare('SELECT id FROM products WHERE id = :id');
            $check->execute([':id' => $id]);

            if (!$check->fetch()) {
                respond([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại.'
                ], 404);
            }

            $stmt = $pdo->prepare(
                'UPDATE products
                 SET name = :name, price = :price, stock = :stock
                 WHERE id = :id'
            );
            $stmt->execute([
                ':name' => $product['name'],
                ':price' => $product['price'],
                ':stock' => $product['stock'],
                ':id' => $id
            ]);

            respond([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.'
            ]);

        case 'DELETE':
            $id = getProductId();

            // DELETE trực tiếp; rowCount() bằng 0 nghĩa là không có bản ghi để xóa.
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                respond([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại.'
                ], 404);
            }

            respond([
                'success' => true,
                'message' => 'Xóa sản phẩm thành công.'
            ]);

        default:
            header('Allow: GET, POST, PUT, DELETE');
            respond([
                'success' => false,
                'message' => 'Phương thức không được hỗ trợ.'
            ], 405);
    }
} catch (PDOException $e) {
    // Ghi chi tiết vào log máy chủ, không gửi thông tin nhạy cảm về DB cho client.
    error_log('Database error in api/products.php: ' . $e->getMessage());
    respond([
        'success' => false,
        'message' => 'Có lỗi xảy ra khi truy vấn cơ sở dữ liệu.'
    ], 500);
} catch (Throwable $e) {
    error_log('API error in api/products.php: ' . $e->getMessage());
    respond([
        'success' => false,
        'message' => 'Đã xảy ra lỗi trên máy chủ.'
    ], 500);
}
