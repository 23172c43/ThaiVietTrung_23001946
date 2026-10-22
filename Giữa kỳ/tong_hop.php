<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài sửa câu 1 và câu 2</title>
</head>
<body>
<h2>Câu 1: Xếp loại học lực</h2>
<?php
$name = "Vu Viet Tan";
$score = 6;

echo "Tên: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";

// Chỉ xếp loại khi điểm là số và nằm trong khoảng 0 đến 10.
if (!is_numeric($score) || $score < 0 || $score > 10) {
    echo "Điểm không hợp lệ. Điểm phải là số từ 0 đến 10.<br>";
} else {
    if ($score >= 8) {
        $xepLoai = "Giỏi";
    } elseif ($score >= 6.5) {
        $xepLoai = "Khá";
    } elseif ($score >= 5) {
        $xepLoai = "Trung bình";
    } else {
        $xepLoai = "Yếu";
    }

    echo "Điểm: " . htmlspecialchars((string) $score, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Xếp loại: " . $xepLoai . "<br>";
}
?>

<h2>Câu 2: Danh sách sản phẩm</h2>
<?php
$danhSachSanPham = [
    ["name" => "Chuột", "price" => 120000],
    ["name" => "laptop", "price" => 20000000],
    ["name" => "USB", "price" => 500000],
    ["name" => "Wave alpha", "price" => 220000000],
    ["name" => "Điện thoại", "price" => 6000000]
];

function calculateTotal($danhSachSanPham)
{
    // Danh sách rỗng có tổng bằng 0, luôn trả về số.
    $total = 0;
    foreach ($danhSachSanPham as $sanPham) {
        $total += $sanPham["price"];
    }
    return $total;
}

function findMaxPrice($danhSachSanPham)
{
    // Trả về null nếu không có sản phẩm, thay vì trả về chuỗi.
    $max = null;
    foreach ($danhSachSanPham as $sanPham) {
        if ($max === null || $sanPham["price"] > $max["price"]) {
            $max = $sanPham;
        }
    }
    return $max;
}

echo "Tổng giá trị sản phẩm: "
    . number_format(calculateTotal($danhSachSanPham), 0, ',', '.') . " đồng<br>";

// Chỉ gọi hàm một lần và kiểm tra kết quả trước khi truy cập mảng.
$sanPhamMax = findMaxPrice($danhSachSanPham);
if ($sanPhamMax === null) {
    echo "Không có sản phẩm nào.<br>";
} else {
    echo "Sản phẩm có giá cao nhất tên là "
        . htmlspecialchars($sanPhamMax["name"], ENT_QUOTES, 'UTF-8')
        . " và có giá là " . number_format($sanPhamMax["price"], 0, ',', '.') . " đồng<br>";
}
?>
</body>
</html>
