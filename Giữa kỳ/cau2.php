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