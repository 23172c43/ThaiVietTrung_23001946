<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý giỏ hàng</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
            color: #222;
            background: #f5f6f8;
        }
        h1 {
            font-size: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #4a6cf7;
            color: #1f2a44;
        }
        h2 { color: #1f2a44; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }
        th, td {
            border: 1px solid #e2e5ea;
            padding: 10px 12px;
            text-align: left;
        }
        th { background: #4a6cf7; color: #fff; }
        tbody tr:nth-child(even) { background: #f8f9fb; }
        tbody tr:hover { background: #eef1fe; }

        .error { color: #d32f2f; font-weight: bold; }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            text-decoration: none;
            border: 1px solid #4a6cf7;
            border-radius: 6px;
            background-color: #4a6cf7;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            transition: background .15s, transform .05s;
        }
        .btn:hover { background-color: #3450d4; }
        .btn:active { transform: translateY(1px); }

        /* Sửa / Xóa trong bảng */
        table a { text-decoration: none; font-weight: 600; }
        table a[href*="edit"] { color: #1e88e5; }
        table a[href*="delete"] { color: #e53935; }
        table a:hover { text-decoration: underline; }

        form p { margin: 12px 0; }
        input[type="text"], input[type="number"] {
            padding: 8px 10px;
            width: 280px;
            max-width: 100%;
            border: 1px solid #c3c8d0;
            border-radius: 6px;
        }
        input:focus { outline: none; border-color: #4a6cf7; }
    </style>
</head>

<body>
    <h1>Hệ thống quản lý Giỏ hàng</h1>        