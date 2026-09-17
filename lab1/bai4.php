<?php

// ==========================================
// 1. ĐỊNH NGHĨA CLASS STUDENT
// ==========================================
class Student {
    // Các thuộc tính (Properties)
    public $name;
    public $age;
    public $score;

    // Hàm khởi tạo (Constructor)
    public function __construct($name, $age, $score) {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    // Method lấy xếp loại
    public function getRank() {
        if ($this->score >= 8.0) {
            return "Giỏi";
        } elseif ($this->score >= 6.5) {
            return "Khá";
        } elseif ($this->score >= 5.0) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    // Method kiểm tra Đạt/Không đạt (Giả sử >= 5.0 là Đạt)
    public function isPassed() {
        return $this->score >= 5.0;
    }

    // Method hiển thị thông tin
    public function display() {
        $status = $this->isPassed() ? "Đạt" : "Không đạt";
        echo "Họ tên: <b>{$this->name}</b> | Tuổi: {$this->age} | Điểm: {$this->score} | Xếp loại: {$this->getRank()} | Trạng thái: {$status}";
    }
}


// ==========================================
// 2. CÁC HÀM XỬ LÝ NGHIỆP VỤ (HELPER FUNCTIONS)
// ==========================================

function findBestStudent($studentList) {
    $bestStudent = $studentList[0];
    foreach ($studentList as $student) {
        if ($student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;
}

function countPassedStudents($studentList) {
    $count = 0;
    foreach ($studentList as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }
    return $count;
}

function calculateAverageScore($studentList) {
    if (empty($studentList)) return 0;
    
    $totalScore = 0;
    foreach ($studentList as $student) {
        $totalScore += $student->score;
    }
    return $totalScore / count($studentList);
}


// ==========================================
// 3. CHƯƠNG TRÌNH CHÍNH (MAIN LOGIC)
// ==========================================

// Khởi tạo các object
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

// Tạo danh sách (mảng chứa các object)
$students = [$student1, $student2, $student3, $student4];

// a. Duyệt danh sách và hiển thị
echo "<h3>Danh sách sinh viên (OOP):</h3>";
echo "<ul>";
foreach ($students as $student) {
    echo "<li>";
    $student->display(); // Gọi method từ object
    echo "</li>";
}
echo "</ul>";

// b. Xử lý các logic thống kê
echo "<h3>Kết quả thống kê:</h3>";
echo "<ul>";

echo "<li><b>Sinh viên có điểm cao nhất:</b><br>";
$best = findBestStudent($students);
$best->display();
echo "</li><br>";

$passedCount = countPassedStudents($students);
echo "<li><b>Số lượng sinh viên đạt:</b> " . $passedCount . " sinh viên</li>";

$avgScore = calculateAverageScore($students);
echo "<li><b>Điểm trung bình của lớp:</b> " . $avgScore . "</li>";

echo "</ul>";

?>