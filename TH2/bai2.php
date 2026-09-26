<?php
// Bật thẻ <pre> để giữ nguyên định dạng khoảng trắng và xuống dòng trên Web Compiler
echo "<pre>";

class Movie {
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    public function __construct($id, $title, $price, $totalSeats){
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats; 
    }

    public function bookTicket($quantity){
        if($quantity <= 0){
            echo "  [LỖI] Số lượng đặt không hợp lệ (<= 0) - Phim: {$this->title}\n";
            return;
        }

        if($quantity > $this->availableSeats){
            echo "  [LỖI] Không đủ ghế trống - Phim: {$this->title} (Yêu cầu: {$quantity}, Còn: {$this->availableSeats})\n";
            return;
        }

        $this->availableSeats -= $quantity;
        echo "  [OK] Đã đặt {$quantity} vé cho phim: {$this->title}\n";
    }

    public function cancelTicket($quantity){
        if($quantity <= 0){
            echo "  [LỖI] Số lượng hủy không hợp lệ (<= 0) - Phim: {$this->title}\n";
            return;
        }

        if($this->totalSeats - $this->availableSeats < $quantity){
            echo "  [LỖI] Không đủ vé đã đặt để hủy - Phim: {$this->title}\n";
            return;
        }

        $this->availableSeats += $quantity;
        echo "  [OK] Đã hủy {$quantity} vé cho phim: {$this->title}\n";
    }

    public function getSoldSeats(){
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(){
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo(){
        echo " [ID: {$this->id}] Phim: {$this->title}\n";
        echo "    - Giá vé        : " . number_format($this->price) . " đ\n";
        echo "    - Tổng ghế      : {$this->totalSeats}\n";
        echo "    - Còn lại       : {$this->availableSeats}\n";
        echo "    - Đã bán        : " . $this->getSoldSeats() . "\n";
        echo "    - Doanh thu     : " . number_format($this->getRevenue()) . " đ\n";
        echo "---------------------------------------------------\n";
    }
}

function findMovieById($movies, $id){
    if(empty($movies)) return null;

    foreach($movies as $movie){
        if($movie->id == $id){
            return $movie;
        }
    }
    return null;
}

function getTotalRevenue($movies){
    if (empty($movies)) return 0;
    $totalRevenue = 0;

    foreach($movies as $movie){
        $totalRevenue += $movie->getRevenue();
    }

    return $totalRevenue;
}

function getBestSellingMovie($movies){
    if (empty($movies)) return null;
    $bestSellingMovie = $movies[0];

    foreach($movies as $movie){
        if($movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()){
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}

$movie1 = new Movie(1, "Avengers", 100000, 100);
$movie2 = new Movie(2, "Avatar", 120000, 80);
$movie3 = new Movie(3, "Batman", 90000, 120);

$movies = [$movie1, $movie2, $movie3];

// ==========================================
// CHƯƠNG TRÌNH CHÍNH (TESTING)
// ==========================================

echo "***************************************************\n";
echo "*       HỆ THỐNG QUẢN LÝ RẠP CHIẾU PHIM           *\n";
echo "***************************************************\n\n";

echo "[1] THỰC HIỆN YÊU CẦU ĐẶT/HỦY VÉ:\n";
// Đặt vé
$movies[0]->bookTicket(50); 
$movies[1]->bookTicket(20); 
// Hủy vé
$movies[0]->cancelTicket(10); 

echo "\n[2] TEST CÁC TRƯỜNG HỢP NGOẠI LỆ:\n";
$movies[0]->bookTicket(0);    
$movies[1]->bookTicket(100);  
$movies[2]->cancelTicket(-5); 
$movies[0]->cancelTicket(50); 

$movieFind = findMovieById($movies, 99);
if ($movieFind === null) {
    echo "  [CẢNH BÁO] Không tìm thấy phim với ID = 99.\n";
}

echo "\n[3] DANH SÁCH THÔNG TIN PHIM:\n";
echo "===================================================\n";
foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo "\n[4] THỐNG KÊ DOANH THU:\n";
echo "===================================================\n";
echo " => TỔNG DOANH THU TẤT CẢ PHIM : " . number_format(getTotalRevenue($movies)) . " VNĐ\n";

$bestMovie = getBestSellingMovie($movies);
if ($bestMovie !== null) {
    echo " => PHIM BÁN CHẠY NHẤT LÀ      : '{$bestMovie->title}' (Đã bán: {$bestMovie->getSoldSeats()} vé)\n";
}
echo "===================================================\n";

// Đóng thẻ <pre>
echo "</pre>";
?>