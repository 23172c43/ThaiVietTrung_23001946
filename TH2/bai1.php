<?php
// Bật thẻ <pre> để giữ nguyên định dạng khoảng trắng và xuống dòng trên Web
echo "<pre>";

class CartItem {
    public $name;
    public $price;
    public $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal() {
        return $this->price * $this->quantity;
    }
}

class ShoppingCart {
    private $items = array();

    public function addItem($item) {
        if ($item->price <= 0) {
            echo "  [LỖI] Sản phẩm '{$item->name}' có giá không hợp lệ (<= 0).\n";
            return;
        }

        if ($item->quantity <= 0) {
            echo "  [LỖI] Sản phẩm '{$item->name}' có số lượng không hợp lệ (<= 0).\n";
            return;
        }

        $this->items[] = $item;
        echo "  [OK] Đã thêm: {$item->name}\n";
    }

    public function removeItem($name) {
        $found = false;

        foreach ($this->items as $index => $item) {
            if ($item->name == $name) {
                unset($this->items[$index]);
                $this->items = array_values($this->items); // Reset index
                $found = true;
                echo "  [OK] Đã xóa: {$name}\n";
                break;
            }
        }

        if (!$found) {
            echo "  [CẢNH BÁO] Không tìm thấy: {$name}\n";
        }
    }

    public function calculateTotal() {
        if (empty($this->items)) return 0;
        
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart() {
        echo "\n===================================================\n";
        echo "                 GIỎ HÀNG CỦA BẠN                  \n";
        echo "===================================================\n";

        if (empty($this->items)) {
            echo "              (Giỏ hàng đang trống)                \n";
            echo "===================================================\n\n";
            return;
        }

        $stt = 1;
        foreach ($this->items as $item) {
            echo " {$stt}. {$item->name}\n";
            echo "    - Đơn giá    : " . str_pad(number_format($item->price) . " đ", 15) . " x {$item->quantity}\n";
            echo "    - Thành tiền : " . number_format($item->getTotal()) . " đ\n";
            echo "---------------------------------------------------\n";
            $stt++;
        }

        echo " TỔNG TIỀN THANH TOÁN:      " . number_format($this->calculateTotal()) . " đ\n";
        echo "===================================================\n\n";
    }
}

// ==========================================
// CHƯƠNG TRÌNH CHÍNH (TESTING)
// ==========================================

echo "***************************************************\n";
echo "*           HỆ THỐNG QUẢN LÝ GIỎ HÀNG             *\n";
echo "***************************************************\n\n";

$cart = new ShoppingCart();

$item1 = new CartItem("Laptop Dell", 15000000, 2);
$item2 = new CartItem("Chuột Logitech", 500000, 1);
$item3 = new CartItem("Bàn phím cơ", 1200000, 1);
$item4 = new CartItem("Màn hình LG", 4000000, 2);
$itemInvalid1 = new CartItem("Sản phẩm giá âm", -50000, 1);
$itemInvalid2 = new CartItem("Sản phẩm số lượng 0", 100000, 0);

echo "[1] THÊM SẢN PHẨM VÀO GIỎ:\n";
$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

echo "\n[2] THÊM SẢN PHẨM KHÔNG HỢP LỆ (TEST NGOẠI LỆ):\n";
$cart->addItem($itemInvalid1); 
$cart->addItem($itemInvalid2); 

echo "\n[3] HIỂN THỊ GIỎ HÀNG HIỆN TẠI:\n";
$cart->displayCart();

echo "[4] XÓA SẢN PHẨM KHỎI GIỎ:\n";
$cart->removeItem("Chuột Logitech");
$cart->removeItem("Sản phẩm không có thật"); // Xóa lỗi

echo "\n[5] KIỂM TRA LẠI GIỎ HÀNG SAU KHI XÓA:\n";
$cart->displayCart();

// Đóng thẻ <pre>
echo "</pre>";
?>