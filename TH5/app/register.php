<?php
require_once 'common/dbConnect.php';
$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username === "" || $password === ""){
        $error = "Vui long nhap day du ten dang nhap va mat khau";
    } else {
        $check_sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $error = "Ten dang nhap da ton tai";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($insert_sql);
            $stmt_insert->bind_param("ss", $username, $hashed_password);

            if($stmt_insert->execute()){
                $success = "Dang ky thanh cong! Chuyen huong...";
                header("refresh:2;url=login.php");
            } else {
                $error = "da xay ra loi he thong";
            }
        }
    }
}
include 'view/header.php';
?>

<h2> Đăng ký tài khoản</h2>
<?php if ($error) echo "<p class='error'>$error</p>"; ?>
<?php if ($success) echo "<p class='success'>$success</p>"; ?>
<form method="POST">
    <p><label>Tên đăng nhập:</label><br><input type="text" name="username" required></p>
    <p><label>Mật khẩu:</label><br><input type="password" name="password" required></p>
    <button type="submit" class="btn">Đăng ký</button>
    <a href="login.php">Đã có tài khoản? Đăng nhập</a>
</form>

<?php include 'view/footer.php'; ?>