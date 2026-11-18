# TH8 - Thực hành PHP và Vue.js

## Cấu trúc

```text
TH8/
├── api/
│   └── products.php
├── common/
│   └── dbConnect.php
├── database.sql
├── index.html
└── README.md
```

## Cách chạy

1. Khởi động Apache và MySQL (ví dụ bằng XAMPP).
2. Mở phpMyAdmin, chọn Import và nhập file `database.sql`.
3. Kiểm tra thông tin kết nối trong `common/dbConnect.php`:
   - Host: `localhost`
   - Database: `vuejs_api_db`
   - User: `root`
   - Password: mặc định đang để trống; sửa lại nếu MySQL trên máy có mật khẩu.
4. Đặt thư mục `TH8` vào thư mục web server, ví dụ `htdocs/TH8`.
5. Truy cập `http://localhost/TH8/`.

Yêu cầu PHP nên dùng PHP 7.4 trở lên; cần PDO MySQL. Nếu có extension `mbstring` thì PHP sử dụng `mb_strlen` để đếm ký tự Unicode; API cũng có phương án dự phòng khi extension này chưa bật.

## API

- `GET api/products.php`: lấy danh sách sản phẩm.
- `POST api/products.php`: thêm sản phẩm, JSON gồm `name`, `price`, `stock`.
- `PUT api/products.php?id=1`: cập nhật sản phẩm.
- `DELETE api/products.php?id=1`: xóa sản phẩm.

`price` và `stock` phải được gửi dưới dạng số nguyên JSON, không gửi dưới dạng chuỗi.

## Kiểm tra nhanh

- Thêm: `name = "Tẩy trắng", price = 4000, stock = 10`.
- Sửa: chọn một sản phẩm, đổi đơn giá rồi lưu.
- Kiểm tra dữ liệu không hợp lệ: gửi `stock = -1` hoặc `price = 0`; API phải trả `success: false` và không ghi dữ liệu.
- Xóa: bấm Xóa và xác nhận; tải lại trang để kiểm tra sản phẩm không còn.
