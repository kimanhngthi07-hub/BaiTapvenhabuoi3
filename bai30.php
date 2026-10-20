<?php
$thongBao = "";
$oldEmail = "";
$oldName = "";

if (isset($_POST['btnGui'])) {
    // 1. Lấy dữ liệu và làm sạch cơ bản (Sanitization)
    $oldName = trim($_POST['hoTen'] ?? '');
    $oldEmail = trim($_POST['email'] ?? '');

    // 2. Validation phía Server (Bắt buộc phải kiểm tra lại dù client có required hay không)
    if ($oldName === "" || $oldEmail === "") {
        $thongBao = '<div class="alert alert-error">⚠️ Lỗi: Không được để trống họ tên hoặc email! (Chặn bởi Server)</div>';
    } elseif (!filter_var($oldEmail, FILTER_VALIDATE_EMAIL)) {
        $thongBao = '<div class="alert alert-error">⚠️ Lỗi: Định dạng email không hợp lệ! (Chặn bởi Server)</div>';
    } else {
        // Dữ liệu hợp lệ tuyệt đối, tiến hành xử lý an toàn
        $safeName = htmlspecialchars($oldName, ENT_QUOTES, 'UTF-8');
        $safeEmail = htmlspecialchars($oldEmail, ENT_QUOTES, 'UTF-8');
        
        $thongBao = '<div class="alert alert-success">✅ Thành công! Dữ liệu đã vượt qua kiểm tra nghiêm ngặt phía Server.<br><b>Họ tên:</b> ' . $safeName . '<br><b>Email:</b> ' . $safeEmail . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 3 - Validation và Xử lý dữ liệu an toàn</title>
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
        input[type="text"] {
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
        .alert {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.5;
        }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; font-weight: bold; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Bài 3: Validation Phía Server</h2>
        
        <div class="rule-box">
            <b>Nguyên tắc cốt lõi:</b> Form HTML có thể dùng <code>required</code> ở client, nhưng <b>luôn phải kiểm tra lại bằng PHP trên server</b> vì người dùng có thể can thiệp hoặc gửi request trực tiếp bằng Postman.
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label>Họ và tên:</label>
                <!-- Giữ lại dữ liệu cũ (sticky form) khi nhập sai -->
                <input type="text" name="hoTen" placeholder="Nhập họ tên..." value="<?php echo htmlspecialchars($oldName); ?>">
            </div>

            <div class="form-group">
                <label>Email liên hệ:</label>
                <input type="text" name="email" placeholder="Nhập email..." value="<?php echo htmlspecialchars($oldEmail); ?>">
            </div>

            <button type="submit" name="btnGui">Gửi dữ liệu</button>
        </form>

        <?php echo $thongBao; ?>
    </div>

</body>
</html>