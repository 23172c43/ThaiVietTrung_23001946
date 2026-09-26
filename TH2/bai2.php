<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý rạp chiếu phim</title>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 20px;
        }

        .container{
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2{
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        h3{
            color: #2980b9;
            margin-top: 20px;
            border-left: 4px solid #2980b9;
            padding-left: 10px;
        }

        .error{
            color: #e74c3c;
            font-weight: bold;
            background: #fadbd8;
            padding: 8px;
            border-radius: 4px;
            border-left: 4px solid #c0392b;
            margin: 5px 0;
        }

        .success{
            color: #27ae60;
            font-weight: bold;
            background: #d5f5e3;
            padding: 8px;
            border-radius: 4px;
            border-left: 4px solid #229954;
            margin: 5px 0;
        }

        .info{
            color: #2c3e50;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            border-left: 4px solid #3498db;
            margin: 5px 0;
        }
    </style>
</head>


<body>
    <div class="container">
        <h2 style="margin-top: 0;">HỆ THỐNG QUẢN LÝ RẠP CHIẾU PHIM</h2>
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
            echo "<div class='error'>So luong khong hop le</div>";
            return;
        }

        if($quantity > $this->availableSeats){
            echo "<div class='error'>Khong du so luong ghe trong</div>";
            return;
        }

        $this->availableSeats -= $quantity;
        echo "<div class='success'>Da dat " . $quantity . " ve cho phim: " . $this->title . "</div>";
    }

    public function cancelTicket($quantity){
        if($quantity <= 0){
            echo "<div class='error'>So luong khong hop le</div>";
            return;
        }

        if($this->totalSeats - $this->availableSeats < $quantity){
            echo "<div class='error'>Khong du so luong ve da dat de huy</div>";
            return;
        }

        $this->availableSeats += $quantity;
        echo "<div class='success'>Da huy " . $quantity . " ve cho phim: " . $this->title . "</div>";
    }

    public function getSoldSeats(){
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(){
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo(){
        echo "<div class='info'>";
        echo "ID: " . $this->id . "<br>";
        echo "Title: " . $this->title . "<br>";
        echo "Price: " . $this->price . "<br>";
        echo "Total Seats: " . $this->totalSeats . "<br>";
        echo "Available Seats: " . $this->availableSeats . "<br>";
        echo "Sold Seats: " . $this->getSoldSeats() . "<br>";
        echo "Revenue: " . $this->getRevenue() . "<br><br>";
        echo "</div>";
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

echo "<h3> THỰC HIỆN YÊU CẦU </h3>";
// 5.2. Đặt vé cho phim Avengers
$movies[0]->bookTicket(50); 
// 5.3. Đặt vé cho phim Avatar
$movies[1]->bookTicket(20); 

// 5.4. Hủy một số vé đã đặt của phim Avengers
$movies[0]->cancelTicket(10); 
echo "<br>";

echo "<h3> TEST CÁC TRƯỜNG HỢP NGOẠI LỆ </h3>";
$movies[0]->bookTicket(0);    
$movies[1]->bookTicket(100);  
$movies[2]->cancelTicket(-5); 
$movies[0]->cancelTicket(50); 
echo "<br>";

$movieFind = findMovieById($movies, 99);
if ($movieFind === null) {
    echo "<div class='error'>Khong tim thay phim voi ID = 99.</div><br>";
}

echo "<h3> DANH SÁCH PHIM </h3>";
foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo "<h3> TỔNG DOANH THU TẤT CẢ CÁC PHIM: " . number_format(getTotalRevenue($movies)) . " VNĐ </h3>";

$bestMovie = getBestSellingMovie($movies);
if ($bestMovie !== null) {
    echo "<div class='info'>=> PHIM BÁN CHẠY NHẤT LÀ: '" . $bestMovie->title . "' (Đã bán: " . $bestMovie->getSoldSeats() . " vé)</div>";
}

?>