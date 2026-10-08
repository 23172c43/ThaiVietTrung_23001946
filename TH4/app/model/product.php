<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts() {
    global $conn;
    // Sửa products thành cart_items
    $sql = "SELECT * FROM cart_items"; 
    $result = $conn->query($sql);
    $products = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addProduct($name, $price, $quantity) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO cart_items (name, price, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name, $price, $quantity);
    return $stmt->execute();
}

function updateProduct($id, $name, $price, $quantity) {
    global $conn;
    $stmt = $conn->prepare("UPDATE cart_items SET name = ?, price = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("sdii", $name, $price, $quantity, $id);
    return $stmt->execute();
}

function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>