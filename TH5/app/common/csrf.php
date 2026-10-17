<?php
function csrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function verifyCsrf(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $expected = $_SESSION['csrf_token'] ?? null;
    $received = $_POST['csrf_token'] ?? null;

    if (
        !is_string($expected) ||
        !is_string($received) ||
        !hash_equals($expected, $received)
    ) {
        http_response_code(403);
        exit('Yêu cầu không hợp lệ (CSRF).');
    }
}
?>