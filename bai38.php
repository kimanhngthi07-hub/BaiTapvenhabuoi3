<?php
// Hàm mã hóa chống XSS an toàn
function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

$errors = [];
$data = [
    'fullname' => '',
    'email' => '',
    'subject' => 'Hỗ trợ kỹ thuật',
    'content' => ''
];
$successMessage = "";
$avatarPath = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Thu thập và làm sạch dữ liệu text (Sanitization)
    $data['fullname'] = trim($_POST['fullname'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['subject'] = trim($_POST['subject'] ?? 'Hỗ trợ kỹ thuật');
    $data['content'] = trim($_POST['content'] ?? '');

    // 2. Validate Họ tên
    if ($data['fullname'] === '') {
        $errors['fullname'] = 'Vui lòng nhập họ tên.';
    }

    // 3. Validate Email
    if ($data['email'] === '') {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng.';
    }

    // 4. Validate Nội dung (phải từ 10 đến 500 ký tự theo mẫu)
    $contentLen = mb_strlen($data['content']);
    if ($data['content'] === '') {
        $errors['content'] = 'Vui lòng nhập nội dung liên hệ.';
    } elseif ($contentLen < 10 || $contentLen > 500) {
        $errors['content'] = 'Nội dung phải từ 10 đến 500 ký tự (Hiện tại: ' . $contentLen . ' ký tự).';
    }

    // 5. Validate Upload ảnh đại diện (3 KIỂM TRA BẮT BUỘC)
    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['avatar'] = 'Vui lòng chọn ảnh đại diện.';
    } elseif ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        $errors['avatar'] = 'Có lỗi xảy ra trong quá trình upload ảnh.';
    } else {
        $file = $_FILES['avatar'];
        
        // Kiểm tra 1: Dung lượng file (Giới hạn tối đa 2MB)
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxSize) {
            $errors['avatar'] = 'Kích thước ảnh quá lớn! Tối đa cho phép là 2MB.';
        }

        // Kiểm tra 2: Đuôi file hợp lệ (Chỉ nhận jpg, jpeg, png, gif, webp)
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowedExts)) {
            $errors['avatar'] = 'Định dạng file không hợp lệ! Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WEBP).';
        }

        // Kiểm tra 3: Kiểm tra định dạng MIME thực sự của ảnh (chống đổi đuôi file giả mạo)
        if (empty($errors['avatar'])) {
            $checkImage = @getimagesize($file['tmp_name']);
            if ($checkImage === false) {
                $errors['avatar'] = 'File upload không phải là hình ảnh hợp lệ!';
            }
        }

        // Nếu hợp lệ 100% thì lưu file vào thư mục 'uploads'
        if (empty($errors)) {
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Tạo tên file ngẫu nhiên chống trùng lặp
            $newFileName = uniqid('avatar_', true) . '.' . $ext;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $avatarPath = 'uploads/' . $newFileName;
            } else {
                $errors['avatar'] = 'Khong thể lưu file upload trên server.';
            }
        }
    }

    // 6. Hiển thị thông báo thành công nếu hợp lệ
    if (empty($errors)) {
        $successMessage = "Gửi thông tin liên hệ thành công!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.8 Thực hành trên lớp: Form liên hệ</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
        }
        .card {
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 520px;
        }
        h2 {
            text-align: center;
            color: #1a365d;
            font-size: 24px;
            margin-bottom: 6px;
        }
        .subtitle {
            text-align: center;
            color: #718096;
            font-size: 13px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #2d3748;
            font-weight: 600;
            font-size: 14px;
        }
        input[type="text"], input[type="email"], select, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 14px;
            color: #2d3748;
            transition: all 0.2s;
        }
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px dashed #cbd5e0;
            border-radius: 6px;
            background: #f7fafc;
            font-size: 13px;
        }
        textarea {
            resize: vertical;
            min-height: 110px;
        }
        .input-error {
            border-color: #e53e3e !important;
            background-color: #fff5f5;
        }
        .error-msg {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }
        button {
            width: 100%;
            background-color: #2176bd;
            color: white;
            border: none;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }
        button:hover {
            background-color: #1a5c96;
        }
        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success h4 { margin-bottom: 8px; font-size: 16px; }
        .alert-success p { font-size: 13px; line-height: 1.5; margin-bottom: 4px; }
        .avatar-preview {
            margin-top: 10px;
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #319795;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Liên hệ</h2>
        <div class="subtitle">Vui lòng nhập đầy đủ thông tin bên dưới.</div>

        <?php if (!empty($successMessage)): ?>
            <div class="alert-success">
                <h4>✅ <?php echo $successMessage; ?></h4>
                <p><b>Họ tên:</b> <?php echo e($data['fullname']); ?></p>
                <p><b>Email:</b> <?php echo e($data['email']); ?></p>
                <p><b>Chủ đề:</b> <?php echo e($data['subject']); ?></p>
                <p><b>Nội dung:</b> <?php echo nl2br(e($data['content'])); ?></p>
                <?php if ($avatarPath): ?>
                    <p><b>Ảnh đại diện đã upload:</b><br>
                    <img src="<?php echo $avatarPath; ?>" class="avatar-preview" alt="Avatar"></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Lưu ý: Form upload file BẮT BUỘC phải có enctype="multipart/form-data" -->
        <form method="POST" action="" enctype="multipart/form-data">
            
            <!-- 1. Họ tên -->
            <div class="form-group">
                <label for="fullname">Họ tên</label>
                <input type="text" id="fullname" name="fullname" 
                       class="<?php echo isset($errors['fullname']) ? 'input-error' : ''; ?>"
                       placeholder="Ví dụ: Lê Văn Hảo" 
                       value="<?php echo e($data['fullname']); ?>">
                <?php if (isset($errors['fullname'])): ?>
                    <div class="error-msg"><?php echo $errors['fullname']; ?></div>
                <?php endif; ?>
            </div>

            <!-- 2. Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       class="<?php echo isset($errors['email']) ? 'input-error' : ''; ?>"
                       placeholder="haovanle@edu.vn" 
                       value="<?php echo e($data['email']); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-msg"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <!-- 3. Chủ đề -->
            <div class="form-group">
                <label for="subject">Chủ đề</label>
                <select id="subject" name="subject">
                    <option value="Hỗ trợ kỹ thuật" <?php echo $data['subject'] === 'Hỗ trợ kỹ thuật' ? 'selected' : ''; ?>>Hỗ trợ kỹ thuật</option>
                    <option value="Góp ý sản phẩm" <?php echo $data['subject'] === 'Góp ý sản phẩm' ? 'selected' : ''; ?>>Góp ý sản phẩm</option>
                    <option value="Hợp tác kinh doanh" <?php echo $data['subject'] === 'Hợp tác kinh doanh' ? 'selected' : ''; ?>>Hợp tác kinh doanh</option>
                    <option value="Khác" <?php echo $data['subject'] === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                </select>
            </div>

            <!-- 4. Upload Ảnh đại diện (Có 3 kiểm tra) -->
            <div class="form-group">
                <label for="avatar">Upload ảnh đại diện (JPG, PNG, GIF, < 2MB)</label>
                <input type="file" id="avatar" name="avatar" accept="image/*"
                       class="<?php echo isset($errors['avatar']) ? 'input-error' : ''; ?>">
                <?php if (isset($errors['avatar'])): ?>
                    <div class="error-msg"><?php echo $errors['avatar']; ?></div>
                <?php endif; ?>
            </div>

            <!-- 5. Nội dung -->
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea id="content" name="content" 
                          class="<?php echo isset($errors['content']) ? 'input-error' : ''; ?>"
                          placeholder="Nhập nội dung liên hệ..."><?php echo e($data['content']); ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="error-msg"><?php echo $errors['content']; ?></div>
                <?php else: ?>
                    <div style="font-size: 11px; color: #a0aec0; margin-top: 4px;">Nội dung phải từ 10 đến 500 ký tự.</div>
                <?php endif; ?>
            </div>

            <button type="submit">Gửi liên hệ</button>
        </form>
    </div>

</body>
</html>