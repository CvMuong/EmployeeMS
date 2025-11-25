# Employee Management System (EMS)

Hệ thống quản lý nhân viên đơn giản được xây dựng bằng PHP thuần, sử dụng kiến trúc MVC.

## Tính năng

- 🔐 Đăng nhập với phân quyền (admin/user)
- 👥 Quản lý danh sách nhân viên (CRUD)
- 🔍 Tìm kiếm và phân trang
- 📸 Upload ảnh đại diện
- 👤 Xem hồ sơ cá nhân
- 🛡️ Bảo mật với CSRF token
- 🗑️ Xóa mềm (soft delete)
- 📡 API endpoint cho danh sách nhân viên

## Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx
- Extension: PDO, GD/Imagick

## Cài đặt

### 1. Clone project

```bash
git clone <repository-url>
cd employee-management-system
```

### 2. Cấu hình database

Tạo file `.env` trong thư mục gốc:

```env
DB_HOST=localhost
DB_NAME=employee_db
DB_USER=root
DB_PASS=

APP_URL=http://localhost
UPLOAD_DIR=uploads
```

### 3. Tạo database

```sql
CREATE DATABASE employee_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE employee_db;

-- Bảng departments
CREATE TABLE departments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng employees
CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_code VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    gender ENUM('male','female','other') DEFAULT 'other',
    dob DATE,
    email VARCHAR(100),
    phone VARCHAR(20),
    department_id INT,
    position VARCHAR(100),
    start_date DATE,
    avatar VARCHAR(255),
    salary DECIMAL(15,2) DEFAULT 0,
    notes TEXT,
    is_deleted TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    employee_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert dữ liệu mẫu
INSERT INTO departments (name) VALUES 
('Phòng Kỹ thuật'),
('Phòng Kinh doanh'),
('Phòng Nhân sự');

-- Tạo tài khoản admin (password: admin123)
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
```

### 4. Tạo thư mục uploads

```bash
mkdir -p public/uploads
chmod 755 public/uploads
```

### 5. Chạy ứng dụng

**Với PHP built-in server:**
```bash
cd public
php -S localhost:8000
```

Truy cập: `http://localhost:8000`

**Với Apache/Nginx:**
- Cấu hình document root trỏ đến thư mục `public/`
- Đảm bảo mod_rewrite được bật (Apache)

## Cấu trúc thư mục

```
.
├── app/
│   ├── controllers/       # Controllers xử lý logic
│   │   ├── ApiController.php
│   │   ├── AuthController.php
│   │   └── EmployeeController.php
│   ├── core/             # Core classes
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── View.php
│   │   ├── Middleware.php
│   │   ├── Validator.php
│   │   ├── bootstrap.php
│   │   └── env.php
│   ├── helpers/          # Helper functions
│   │   ├── upload.php
│   │   └── csrf.php
│   ├── models/           # Models
│   │   ├── Employee.php
│   │   └── User.php
│   └── views/            # View templates
│       ├── auth/
│       ├── employees/
│       └── layouts/
├── public/
│   ├── uploads/          # Thư mục lưu ảnh
│   ├── index.php         # Entry point
│   └── style.css         # CSS
├── .env                  # Cấu hình (không commit)
├── .gitignore
└── README.md
```

## Tài khoản mặc định

| Username | Password | Role  |
|----------|----------|-------|
| admin    | admin123 | admin |

**Lưu ý:** Đổi mật khẩu ngay sau khi đăng nhập lần đầu trong môi trường production.

## Hướng dẫn sử dụng

### Đăng nhập
Truy cập `http://localhost:8000/?route=login`

### Quản lý nhân viên (Quyền Admin)

**Xem danh sách:**
```
?route=employees/index
```

**Thêm mới:**
```
?route=employees/create
```

**Sửa:**
```
?route=employees/edit&id={id}
```

**Xem chi tiết:**
```
?route=employees/show&id={id}
```

**Xóa:**
Sử dụng nút "Xóa" trong danh sách (soft delete)

### Xem hồ sơ cá nhân

```
?route=employees/profile
```

### API Endpoint

**GET** `?route=api/employees`

**Tham số:**
- `limit` (int, mặc định: 10) - Số bản ghi trên trang
- `page` (int, mặc định: 1) - Trang hiện tại
- `keyword` (string) - Từ khóa tìm kiếm

**Ví dụ:**
```bash
curl "http://localhost:8000/?route=api/employees&limit=20&page=1&keyword=nguyen"
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "employee_code": "NV001",
      "fullname": "Nguyễn Văn A",
      "email": "nguyenvana@example.com",
      "phone": "0123456789",
      "department": "Phòng Kỹ thuật",
      ...
    }
  ],
  "total": 100,
  "page": 1,
  "limit": 20
}
```

## Bảo mật

- ✅ CSRF protection cho tất cả form POST
- ✅ Password hashing với bcrypt
- ✅ Prepared statements (PDO) - chống SQL injection
- ✅ File upload validation (type, size)
- ✅ Role-based access control (RBAC)
- ✅ XSS protection với htmlspecialchars()
- ✅ Session management

## Upload ảnh

**Quy định:**
- Định dạng: JPG, PNG
- Kích thước tối đa: 2MB
- Tên file tự động: `img_<uniqid>.<ext>`

## Phân quyền

| Chức năng | Admin | User |
|-----------|-------|------|
| Xem danh sách | ✅ | ✅ |
| Xem chi tiết | ✅ | ✅ |
| Thêm mới | ✅ | ❌ |
| Sửa | ✅ | ❌ |
| Xóa | ✅ | ❌ |
| Xem hồ sơ | ✅ | ✅ |

## Troubleshooting

**Lỗi kết nối database:**
```
Kiểm tra file .env và thông tin database
```

**Lỗi upload ảnh:**
```bash
# Kiểm tra quyền thư mục
chmod 755 public/uploads

# Kiểm tra PHP settings
upload_max_filesize = 2M
post_max_size = 8M
```

**Lỗi 404:**
```
Đảm bảo đang truy cập từ thư mục public/
```

## Ghi chú kỹ thuật

- **Soft Delete:** Nhân viên bị xóa vẫn tồn tại trong DB với `is_deleted=1`
- **Session:** Timeout theo cấu hình PHP (mặc định 1440 giây)
- **Pagination:** 10 bản ghi/trang (có thể thay đổi trong controller)
- **Bootstrap 5.3.2** cho UI
- **Không sử dụng Composer** - PHP thuần

## Phát triển thêm

Một số tính năng có thể mở rộng:
- Quản lý phòng ban (CRUD departments)
- Export danh sách ra Excel/PDF
- Chấm công và quản lý lương
- Upload nhiều ảnh
- Reset password
- Email notification
- Audit log

## License

MIT License

---

**Phát triển bởi:** Your Name  
**Năm:** 2024