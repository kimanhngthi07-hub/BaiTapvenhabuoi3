<?php
// Hàm mã hóa output chống XSS theo đúng slide
function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

$errors = [];
$data = ['name' => '', 'email' => '', 'birthday' => ''];
$thongBaoThanhCong = "";

// Kiểm tra khi người dùng submit form bằng phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Làm sạch dữ liệu đầu vào (Sanitization)
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['birthday'] = trim($_POST['birthday'] ?? '');

    // Validate bắt buộc nhập và đúng định dạng
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên';
    }
    
    if ($data['email'] === '') {
        $errors['email'] = 'Vui lòng nhập email';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }
    
    if ($data['birthday'] === '') {
        $errors['birthday'] = 'Vui lòng nhập ngày sinh';
    }

    // Nếu không có lỗi nào xảy ra -> Xử lý thành công & Redirect
    if (empty($errors)) {
        // Trong thực tế sẽ lưu vào Database ở đây. Sau đó chuyển hướng:
        // header('Location: success.php'); exit;
        
        // Demo hiển thị thông báo thành công trực tiếp trên trang
        $thongBaoThanhCong = "Đăng ký thành công cho sinh viên: <b>" . e($data['name']) . "</b>!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 3.7 - Form Đăng Ký Sinh Viên</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 20px; font-size: 22px; }
        .rule-box {
            background: #e8f4fd;
            border-left: 5px solid #2196F3;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 13px;
            color: #0d47a1;
            line-height: 1.4;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555555; font-weight: 600; font-size: 14px; }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 11px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
        }
        input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            font-weight: bold;
        }
        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 5px;
        }
        button:hover { background-color: #218838; }
        .alert-success {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Form Đăng Ký Sinh Viên</h2>
        
        <div class="rule-box">
            <b>Cấu trúc chuẩn:</b> Tách mảng <code>$data</code> và <code>$errors</code>, dùng hàm <code>filter_var()</code> kiểm tra email và hàm <code>e()</code> chống XSS.
        </div>

        <?php if (!empty($thongBaoThanhCong)): ?>
            <div class="alert-success">
                ✅ <?php echo $thongBaoThanhCong; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Họ tên sinh viên:</label>
                <input type="text" name="name" placeholder="Nhập họ và tên..." value="<?php echo e($data['name']); ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="error-text"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Địa chỉ Email:</label>
                <input type="text" name="email" placeholder="Nhập email..." value="<?php echo e($data['email']); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-text"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="birthday" value="<?php echo e($data['birthday']); ?>">
                <?php if (isset($errors['birthday'])): ?>
                    <div class="error-text"><?php echo $errors['birthday']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Đăng ký ngay</button>
        </form>
    </div>

</body>
</html>