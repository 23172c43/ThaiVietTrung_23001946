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

echo "<h3>Danh sách thông tin sinh viên:</h3>";
echo "<ul>";

// 2. Sử dụng foreach để duyệt mảng và in thông tin
foreach ($students as $student) {
    echo "<li>";
    echo "Họ tên: <b>" . $student['name'] . "</b> | ";
    echo "Tuổi: " . $student['age'] . " | ";
    echo "Điểm: " . $student['score'];
    echo "</li>";
    
}
echo "</ul>";

function calculateAverageScore($students){
    $totalScore = 0;
    $totalStudents = count($students);

    foreach ($students as $student) {
        $totalScore += $student['score'];
    }

    return $totalScore / $totalStudents;
}

echo "<h3>Kết quả thống kê:</h3>";

echo "Điểm trung bình: " . calculateAverageScore($students);

echo "<br>";

function getRank($score){
    if ($score >= 8){
        return "Giỏi";
    } else if ($score >= 6.5){
        return "Khá";
    } else if ($score >= 5){
        return "Trung bình";
    } else {
        return "Yếu";
    }
}

echo "Xếp hạng cho sinh viên " . $students[0]['name'] . ": " . getRank($students[0]['score']);

echo "<br>";

function displayStudent($student){
    echo "Họ tên: <b>" . $student['name'] . "</b> | ";
    echo "Tuổi: " . $student['age'] . " | ";
    echo "Điểm: " . $student['score'] . " | ";
    echo "Xếp hạng: " . getRank($student['score']);
}

echo "<h3>Thông tin chi tiết của sinh viên:</h3>";
displayStudent($students[0]);
echo "<br>";

?>