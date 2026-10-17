<?php
function csrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function verifyCsrf(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_POST['csrf_token']) || !is_string($_POST['csrf_token']) ||
        !hash_equals(csrfToken(), $_POST['csrf_token'])) {
        http_response_code(403);
        exit('Yêu cầu không hợp lệ (CSRF).');
    }
}
