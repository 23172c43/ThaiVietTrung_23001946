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
            echo "San pham khong hop le <br>";
            return;
        }

        if($item->quantity <= 0){
            echo "So luong khong hop le <br>";
            return;
        }

        $this->items[] = $item;

        echo "Da them san pham vao gio hang: " . $item->name . "<br>";
    }

    public function removeItem($name){
        $found = false;

        foreach ($this->items as $index => $item){
            if($item->name == $name){
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                $found = true;
                echo "Da xoa san pham: " . $name . "<br>";
                break;
            }
        }

        if(!$found){
            echo "Khong tim thay san pham: " . $name . "<br>";
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
            echo "Gio hang trong<br>";
            return;
        }

        echo "Gio hang:<br>";

        foreach($this->items as $item){
            echo "San pham: " . $item->name . ", Gia: " . $item->price . ", So luong: " . $item->quantity . ", Tong: " . $item->getTotal() . "<br>";
        }

        echo "Tong tien: " . $this->calculateTotal() . "<br>";
    }    
}

// 3. Chương trình chính (Testing)
echo "--- CHẠY THỬ NGHIỆM BÀI 1 --- <br>";

// 1. Tạo một object ShoppingCart.
$cart = new ShoppingCart();

// 2. Tạo ít nhất 04 object CartItem (Bao gồm cả item không hợp lệ để test).
$item1 = new CartItem("Laptop Dell", 15000000, 2);
$item2 = new CartItem("Chuột Logitech", 500000, 1);
$item3 = new CartItem("Bàn phím cơ", 1200000, 1);
$item4 = new CartItem("Màn hình LG", 4000000, 2);
$itemInvalid1 = new CartItem("Sản phẩm giá âm", -50000, 1);
$itemInvalid2 = new CartItem("Sản phẩm số lượng 0", 100000, 0);

echo "--- Thêm sản phẩm vào giỏ hàng --- <br>";
// 3. Thêm các sản phẩm vào giỏ hàng bằng method addItem().
$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);
// Test ngoại lệ
$cart->addItem($itemInvalid1); 
$cart->addItem($itemInvalid2); 

echo "<br>";

// 4. Hiển thị toàn bộ giỏ hàng và 5. Tính tổng tiền (đã tích hợp trong displayCart).
$cart->displayCart();

echo "<br>";

// 6. Xóa một sản phẩm theo tên.
$cart->removeItem("Chuột Logitech");
// Test xóa sản phẩm không tồn tại
$cart->removeItem("Sản phẩm không có thật");

echo "<br>";

// 7. Hiển thị lại giỏ hàng sau khi xóa.
$cart->displayCart();

?>