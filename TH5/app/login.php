<?php
session_start();
require_once 'common/dbConnect.php';

if(isset($_SESSION['username'])){
    header("Location: product_list.php");
    exit();
}

$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Mật khẩu không chính xác";
        }
    } else {
        $error = "Tên đăng nhập không tồn tại.";
    }
}

include 'view/header.php';
?>

<h2>Đăng nhập</h2>
<?php if($error) echo "<p class='error'> $error </p>"; ?>
<form method="POST">
    <p><label>Tên đăng nhập:</label><br><input type="text" name="username" required></p>
    <p><label>Mật khẩu:</label><br><input type="password" name="password" required></p>
    <button type="submit" class="btn">Đăng nhập</button>
    <br><br>
    <a href="register.php">Chưa có tài khoản? Đăng ký ngay</a>
</form>

<?php include 'view/footer.php'; ?>