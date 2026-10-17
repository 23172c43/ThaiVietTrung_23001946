
<?php
session_start();

require_once 'common/dbConnect.php';
require_once 'common/csrf.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: product_list.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $conn->prepare(
            'SELECT id, username, password FROM users WHERE username = ?'
        );

        $stmt->bind_param('s', $username);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];

            // Tạo lại CSRF token sau khi đăng nhập
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: product_list.php');
            exit();
        }

        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}

include 'view/header.php';
?>

<h2>Đăng nhập</h2>

<?php if ($error): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"
    >

    <p>
        <label>
            Tên đăng nhập:<br>
            <input
                type="text"
                name="username"
                required
                maxlength="50"
                autocomplete="username"
            >
        </label>
    </p>

    <p>
        <label>
            Mật khẩu:<br>
            <input
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >
        </label>
    </p>

    <button type="submit" class="btn">
        Đăng nhập
    </button>

    <p>
        <a href="register.php">
            Chưa có tài khoản? Đăng ký
        </a>
    </p>
</form>

<?php include 'view/footer.php'; ?>
