Employee Management System (EMS)
Hệ thống quản lý nhân viên đơn giản được xây dựng bằng PHP thuần, sử dụng kiến trúc MVC.
Tính năng

🔐 Đăng nhập với phân quyền (admin/user)
👥 Quản lý danh sách nhân viên (CRUD)
🔍 Tìm kiếm và phân trang
📸 Upload ảnh đại diện
👤 Xem hồ sơ cá nhân
🛡️ Bảo mật với CSRF token
🗑️ Xóa mềm (soft delete)
📡 API endpoint cho danh sách nhân viên

Yêu cầu hệ thống

PHP >= 7.4
MySQL >= 5.7
Apache/Nginx
Extension: PDO, GD/Imagick

Cài đặt
1. Clone project
bashgit clone <repository-url>
cd employee-management-system
2. Cấu hình database
Tạo file .env từ template:
envDB_HOST=localhost
DB_NAME=employee_db
DB_USER=root
DB_PASS=

APP_URL=http://localhost
UPLOAD_DIR=uploads
3. Import database
sql-- Tạo database
CREATE DATABASE employee_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Import schema (xem file SQL đính kèm)
4. Tạo thư mục uploads
bashmkdir public/uploads
chmod 755 public/uploads
5. Chạy ứng dụng
Với PHP built-in server:
bashcd public
php -S localhost:8000
```

**Với Apache:** Truy cập qua `http://localhost/employee-management-system/public`

## Cấu trúc thư mục
```
.
├── app/
│   ├── controllers/       # Controllers xử lý logic
│   ├── core/             # Core classes (Router, Database, View...)
│   ├── helpers/          # Helper functions (upload, csrf...)
│   ├── models/           # Models tương tác database
│   └── views/            # View templates
├── public/
│   ├── uploads/          # Thư mục lưu ảnh
│   ├── index.php         # Entry point
│   └── style.css         # CSS tùy chỉnh
└── .env                  # Cấu hình môi trường
```

## Tài khoản mặc định

Sau khi import database và chạy `seed_admin.php`:

| Username | Password | Role  |
|----------|----------|-------|
| admin    | admin123 | admin |
| user     | user123  | user  |

## Sử dụng

### Đăng nhập
Truy cập `?route=login` để đăng nhập vào hệ thống.

### Quản lý nhân viên (Admin)
- **Thêm mới:** `?route=employees/create`
- **Sửa:** `?route=employees/edit&id={id}`
- **Xóa:** Click nút "Xóa" trong danh sách
- **Xem chi tiết:** `?route=employees/show&id={id}`

### Xem hồ sơ cá nhân
Truy cập `?route=employees/profile` để xem thông tin cá nhân.

### API Endpoint

**GET** `?route=api/employees`

Tham số:
- `limit` (mặc định: 10) - Số bản ghi trên trang
- `page` (mặc định: 1) - Trang hiện tại
- `keyword` - Từ khóa tìm kiếm

Ví dụ:
```
GET ?route=api/employees&limit=20&page=1&keyword=nguyen
Response:
json{
  "data": [...],
  "total": 100,
  "page": 1,
  "limit": 20
}
Bảo mật

✅ CSRF protection cho tất cả form
✅ Password hashing với bcrypt
✅ Prepared statements (PDO) chống SQL injection
✅ Validation file upload (loại file, kích thước)
✅ Phân quyền admin/user
✅ XSS protection với htmlspecialchars