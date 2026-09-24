<?php

class Movie{
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    // Đã sửa: Bỏ $availableSeats khỏi tham số
    public function __construct($id, $title, $price, $totalSeats){
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats; 
    }

    public function bookTicket($quantity){
        if($quantity <= 0){
            echo "So luong khong hop le <br>";
            return;
        }

        if($quantity > $this->availableSeats){
            echo "Khong du so luong ghe trong <br>";
            return;
        }

        $this->availableSeats -= $quantity;
        echo "Da dat " . $quantity . " ve cho phim: " . $this->title . "<br>";
    }

    public function cancelTicket($quantity){
        if($quantity <= 0){
            echo "So luong khong hop le <br>";
            return;
        }

        if($this->totalSeats - $this->availableSeats < $quantity){
            echo "Khong du so luong ve da dat de huy <br>";
            return;
        }

        $this->availableSeats += $quantity;
        echo "Da huy " . $quantity . " ve cho phim: " . $this->title . "<br>";
    }

    public function getSoldSeats(){
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(){
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo(){
        echo "ID: " . $this->id . "<br>";
        echo "Title: " . $this->title . "<br>";
        echo "Price: " . $this->price . "<br>";
        echo "Total Seats: " . $this->totalSeats . "<br>";
        echo "Available Seats: " . $this->availableSeats . "<br>";
        echo "Sold Seats: " . $this->getSoldSeats() . "<br>";
        echo "Revenue: " . $this->getRevenue() . "<br><br>";
    }
}

function findMovieById($movies, $id){
    if(empty($movies)) return null;

    foreach($movies as $movie){
        if($movie->id == $id){
            return $movie;
        }
    }
    // Đã sửa: Chuyển return null ra ngoài
    return null;
}

function getTotalRevenue($movies){
    if (empty($movies)) return 0;
    $totalRevenue = 0;

    // Đã sửa: Thêm dấu $ trước movie
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

$movie1 = new Movie(1, "Avengers", 100_000, 100);
$movie2 = new Movie(2, "Avatar", 120_000, 80);
$movie3 = new Movie(3, "Batman", 90_000, 120);

$movies = [$movie1, $movie2, $movie3];

echo "--- THỰC HIỆN YÊU CẦU ---<br>";
// 5.2. Đặt vé cho phim Avengers
$movies[0]->bookTicket(50); 
// 5.3. Đặt vé cho phim Avatar
$movies[1]->bookTicket(20); 

// 5.4. Hủy một số vé đã đặt của phim Avengers
$movies[0]->cancelTicket(10); 
echo "<br>";

echo "--- TEST CÁC TRƯỜNG HỢP NGOẠI LỆ ---<br>";
$movies[0]->bookTicket(0);    
$movies[1]->bookTicket(100);  
$movies[2]->cancelTicket(-5); 
$movies[0]->cancelTicket(50); 
echo "<br>";

$movieFind = findMovieById($movies, 99);
if ($movieFind === null) {
    echo "Khong tim thay phim voi ID = 99.<br><br>";
}

echo "--- DANH SÁCH PHIM ---<br>";
foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo "=> TỔNG DOANH THU TẤT CẢ CÁC PHIM: " . number_format(getTotalRevenue($movies)) . " VNĐ<br>";

$bestMovie = getBestSellingMovie($movies);
if ($bestMovie !== null) {
    echo "=> PHIM BÁN CHẠY NHẤT LÀ: '" . $bestMovie->title . "' (Đã bán: " . $bestMovie->getSoldSeats() . " vé)<br>";
}

?>