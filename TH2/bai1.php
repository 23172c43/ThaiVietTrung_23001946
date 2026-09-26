<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý giỏ hàng</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top: 30px; }
        h3 { color: #2980b9; margin-top: 20px; border-left: 4px solid #2980b9; padding-left: 10px;}
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }  
        .error { color: #e74c3c; font-weight: bold; background: #fadbd8; padding: 8px; border-radius: 4px; border-left: 4px solid #c0392b; margin: 5px 0;}
        .success { color: #27ae60; font-weight: bold; background: #d5f5e3; padding: 8px; border-radius: 4px; border-left: 4px solid #229954; margin: 5px 0;}
        .total-row { font-weight: bold; text-align: right; font-size: 1.1em; }
        .total-price { color: #e74c3c; font-size: 1.2em; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-top: 0;">HỆ THỐNG QUẢN LÝ GIỎ HÀNG</h2>

<?php

class CartItem{
    public $name;
    public $price;
    public $quantity;

    public function __construct($name, $price, $quantity){
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal(){
        return $this->price * $this->quantity;
    }
}

class ShoppingCart{
    private $items = array();

    public function addItem($item){
        if($item->price <= 0){
            echo "<div class='error'>Lỗi: Sản phẩm '{$item->name}' có giá không hợp lệ (<= 0).</div>";
            return;
        }

        if($item->quantity <= 0){
            echo "<div class='error'>Lỗi: Sản phẩm '{$item->name}' có số lượng không hợp lệ (<= 0).</div>";
            return;
        }

        $this->items[] = $item;
        echo "<div class='success'>Đã thêm sản phẩm vào giỏ hàng: <b>{$item->name}</b></div>";
    }

    public function removeItem($name){
        $found = false;

        foreach ($this->items as $index => $item){
            if($item->name == $name){
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                $found = true;
                echo "<div class='success'>Đã xóa sản phẩm: <b>{$name}</b></div>";
                break;
            }
        }

        if(!$found){
            echo "<div class='error'>Không tìm thấy sản phẩm: <b>{$name}</b> để xóa.</div>";
        }
    }

    public function calculateTotal(){
        if(empty($this->items)){
            return 0;
        }

        $total = 0;
        foreach($this->items as $item){
            $total += $item->getTotal();
        }

        return $total;
    }

    public function displayCart(){
        if(empty($this->items)){
            echo "<div style='text-align:center; padding: 20px; background:#f9f9f9; border: 1px dashed #ccc;'>Giỏ hàng đang trống!</div>";
            return;
        }

        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
              </thead>";
        echo "<tbody>";

        foreach($this->items as $item){
            echo "<tr>";
            echo "<td>{$item->name}</td>";
            echo "<td>" . number_format($item->price) . " đ</td>";
            echo "<td>{$item->quantity}</td>";
            echo "<td>" . number_format($item->getTotal()) . " đ</td>";
            echo "</tr>";
        }

        echo "<tr>
                <td colspan='3' class='total-row'>TỔNG TIỀN THANH TOÁN:</td>
                <td class='total-price'>" . number_format($this->calculateTotal()) . " đ</td>
              </tr>";
        echo "</tbody>";
        echo "</table>";
    }    
}

// ==========================================
// CHƯƠNG TRÌNH CHÍNH (TESTING)
// ==========================================

$cart = new ShoppingCart();

$item1 = new CartItem("Laptop Dell", 15000000, 2);
$item2 = new CartItem("Chuột Logitech", 500000, 1);
$item3 = new CartItem("Bàn phím cơ", 1200000, 1);
$item4 = new CartItem("Màn hình LG", 4000000, 2);
$itemInvalid1 = new CartItem("Sản phẩm giá âm", -50000, 1);
$itemInvalid2 = new CartItem("Sản phẩm số lượng 0", 100000, 0);

echo "<h3>1. Thêm sản phẩm vào giỏ</h3>";
$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

echo "<h3>2. Thêm sản phẩm không hợp lệ (Test ngoại lệ)</h3>";
$cart->addItem($itemInvalid1); 
$cart->addItem($itemInvalid2); 

echo "<h3>3. Hiển thị giỏ hàng hiện tại</h3>";
$cart->displayCart();

echo "<h3>4. Xóa sản phẩm khỏi giỏ</h3>";
$cart->removeItem("Chuột Logitech");
$cart->removeItem("Sản phẩm không có thật");

echo "<h3>5. Giỏ hàng sau khi xóa</h3>";
$cart->displayCart();

?>

</div> <!-- End container -->
</body>
</html>