
<?php
require_once 'common/dbConnect.php';
require_once 'common/csrf.php';

$error = '';
$success = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $rawUsername = $_POST['username'] ?? '';
    $rawPassword = $_POST['password'] ?? '';

    $username = is_string($rawUsername)
        ? trim($rawUsername)
        : '';

    $password = is_string($rawPassword)
        ? $rawPassword
        : '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif (mb_strlen($username, 'UTF-8') > 50) {
        $error = 'Tên đăng nhập không được quá 50 ký tự.';
    } elseif (strlen($password) < 8) {
        $error = 'Mật khẩu phải có ít nhất 8 ký tự.';
    } else {
        $stmt = $conn->prepare(
            'SELECT id FROM users WHERE username = ?'
        );

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Tên đăng nhập đã tồn tại.';
        } else {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $insert = $conn->prepare(
                'INSERT INTO users (username, password) VALUES (?, ?)'
            );

            $insert->bind_param(
                'ss',
                $username,
                $hashedPassword
            );

            try {
                if ($insert->execute()) {
                    $success = 'Đăng ký thành công! Đang chuyển đến trang đăng nhập...';
                    header('Refresh: 2; url=login.php');
                } else {
                    $error = 'Không thể tạo tài khoản.';
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    $error = 'Tên đăng nhập đã tồn tại.';
                } else {
                    error_log($e->getMessage());
                    $error = 'Đã xảy ra lỗi hệ thống.';
                }
            }
        }
    }
}

include 'view/header.php';
?>

<h2>Đăng ký tài khoản</h2>

<?php if ($error): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if ($success): ?>
    <p class="success">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if (!$success): ?>
<form method="POST">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"
    >

    <p>
        <label for="username">Tên đăng nhập:</label><br>
        <input
            type="text"
            id="username"
            name="username"
            required
            maxlength="50"
            autocomplete="username"
            value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
        >
    </p>

    <p>
        <label for="password">Mật khẩu:</label><br>
        <input
            type="password"
            id="password"
            name="password"
            required
            minlength="8"
            autocomplete="new-password"
        >
    </p>

    <button type="submit" class="btn">Đăng ký</button>
</form>
<?php endif; ?>

<p>
    <a href="login.php">Đã có tài khoản? Đăng nhập</a>
</p>

<?php include 'view/footer.php'; ?>
