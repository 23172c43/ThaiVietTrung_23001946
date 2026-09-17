<?php
// 1. Khai báo mảng danh sách sinh viên
$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

// Khởi tạo biến lưu tổng điểm
$totalScore = 0;
// Lấy số lượng sinh viên trong mảng
$totalStudents = count($students);

echo "<h3>Danh sách thông tin sinh viên:</h3>";
echo "<ul>";

// 2. Sử dụng foreach để duyệt mảng và in thông tin
foreach ($students as $student) {
    echo "<li>";
    echo "Họ tên: <b>" . $student['name'] . "</b> | ";
    echo "Tuổi: " . $student['age'] . " | ";
    echo "Điểm: " . $student['score'];
    echo "</li>";
    
    // Cộng dồn điểm của từng sinh viên vào tổng
    $totalScore += $student['score'];
}
echo "</ul>";

// 3. Tính và in điểm trung bình
$averageScore = $totalScore / $totalStudents;

echo "<h3>Kết quả thống kê:</h3>";
echo "<b>Điểm trung bình của tất cả sinh viên: </b>" . $averageScore;
?>