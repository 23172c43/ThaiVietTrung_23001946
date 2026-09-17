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


function displayStudent($student){
    echo "Họ tên: <b>" . $student['name'] . "</b> | ";
    echo "Tuổi: " . $student['age'] . " | ";
    echo "Điểm: " . $student['score'] . " | ";
}

// Học sinh có điểm cao nhất 

function findBestStudent($students){
    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student['score'] > $bestStudent['score']) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

echo "<h3>Danh sách thông tin sinh viên:</h3>";
echo "<ul>";
// 2. Sử dụng foreach để duyệt mảng và in thông tin

foreach ($students as $student) {
    echo "<li>";
    displayStudent($student);
    echo "</li>";
}
echo "</ul>";

echo "<h3>Kết quả thống kê:</h3>";

echo "<h3>Sinh viên có điểm cao nhất:</h3>";
$bestStudent = findBestStudent($students);
echo displayStudent($bestStudent);

// Tìm học sinh có điểm thấp nhất 

function findWorstStudent($students){
    $worstStudent = $students[0];

    foreach ($students as $student) {
        if ($student['score'] < $worstStudent['score']) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

echo "<h3>Sinh viên có điểm thấp nhất:</h3>";
$worstStudent = findWorstStudent($students);
echo displayStudent($worstStudent);

// Đếm có sinh viên đạt 

function countPassedStudents($students){
    $count = 0;

    foreach ($students as $student) {
        if ($student['score'] >= 5) {
            $count++;
        }
    }

    return $count;
}

echo "<h3>Số lượng sinh viên đạt điểm:</h3>";
echo countPassedStudents($students);

// Tìm sinh viên theo tên và trả về sinh viên tìm được 
function findStudentByNames($students, $name){
    foreach ($students as $student) {
        if ($student['name'] === $name) {
            return $student;
        }
    }
    return null;
}

echo "<h3>Tìm sinh viên theo tên:</h3>";
$searchName = "Tran Thi Binh";
$foundStudent = findStudentByNames($students, $searchName);
if ($foundStudent) {
    echo "Sinh viên tìm thấy: ";
    displayStudent($foundStudent);
} else {
    echo "Không tìm thấy sinh viên có tên: " . $searchName;
}
?>