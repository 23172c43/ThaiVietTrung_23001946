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