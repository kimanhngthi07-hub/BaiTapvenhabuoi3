<?php
// Bắt buộc phải gọi session_start() ở đầu tiên file để lưu trữ danh sách qua các lần bấm nút
session_start();

// Nếu chưa có danh sách trong session, khởi tạo mảng mặc định ban đầu
if (!isset($_SESSION['danhSachSV'])) {
    $_SESSION['danhSachSV'] = [
        ['name' => 'An', 'score' => 8.0],
        ['name' => 'Bình', 'score' => 6.5],
        ['name' => 'Chi', 'score' => 4.5]
    ];
}

$thongBao = "";

// Xử lý thêm sinh viên bằng POST
if (isset($_POST['btnThem'])) {
    $tenMoi = trim($_POST['tenMoi']);
    $diemMoi = trim($_POST['diemMoi']);
    
    if ($tenMoi !== "" && is_numeric($diemMoi)) {
        // Thêm sinh viên mới vào mảng trong SESSION
        $_SESSION['danhSachSV'][] = [
            'name' => $tenMoi,
            'score' => (float)$diemMoi
        ];
        $thongBao = '<div class="alert alert-success">Đã thêm thành công sinh viên: <b>' . htmlspecialchars($tenMoi) . '</b> (Điểm: ' . $diemMoi . ') qua <code>$_POST</code>!</div>';
    } else {
        $thongBao = '<div class="alert alert-error">Vui lòng nhập tên và điểm hợp lệ!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 2.6 - GET và POST</title>
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
            max-width: 600px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 20px; font-size: 22px; }
        .section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        .section h3 { font-size: 16px; margin-bottom: 12px; color: #0d47a1; }
        .form-group { margin-bottom: 12px; }
        label { display: block; margin-bottom: 5px; color: #555555; font-weight: 600; font-size: 13px; }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover { background-color: #357abd; }
        .btn-post { background-color: #28a745; }
        .btn-post:hover { background-color: #218838; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        th { background-color: #e9ecef; color: #333; }
        .alert {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            text-align: center;
            font-weight: bold;
        }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Quản Lý Sinh Viên (GET & POST)</h2>

        <!-- 1. Form tìm kiếm dùng GET -->
        <div class="section">
            <h3>🔍 Tìm kiếm sinh viên (Dùng $_GET)</h3>
            <form method="GET" action="">
                <div class="form-group">
                    <input type="text" name="tukhoa" placeholder="Nhập tên sinh viên cần tìm..." value="<?php echo isset($_GET['tukhoa']) ? htmlspecialchars($_GET['tukhoa']) : ''; ?>">
                </div>
                <button type="submit">Tìm kiếm</button>
                <?php if(isset($_GET['tukhoa']) && $_GET['tukhoa'] !== ''): ?>
                    <a href="get_post.php" style="margin-left: 10px; font-size: 14px; text-decoration: none; color: #d9534f;">Xóa lọc</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- 2. Form thêm sinh viên dùng POST -->
        <div class="section">
            <h3>➕ Thêm sinh viên mới (Dùng $_POST)</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Họ tên sinh viên:</label>
                    <input type="text" name="tenMoi" placeholder="Ví dụ: Ngọc Anh" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Điểm số:</label>
                    <input type="text" name="diemMoi" placeholder="Ví dụ: 9" autocomplete="off" required>
                </div>
                <button type="submit" name="btnThem" class="btn-post">Thêm sinh viên</button>
            </form>
            <?php echo $thongBao; ?>
        </div>

        <!-- Hiển thị bảng danh sách -->
        <div class="section" style="background: #fff;">
            <h3>📋 Bảng danh sách sinh viên</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ và Tên</th>
                        <th>Điểm số</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tukhoa = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : '';
                    $stt = 1;
                    $found = false;

                    foreach ($_SESSION['danhSachSV'] as $sv) {
                        // Lọc theo từ khóa GET nếu có
                        if ($tukhoa !== "" && mb_stripos($sv['name'], $tukhoa) === false) {
                            continue;
                        }
                        $found = true;
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td><b>" . htmlspecialchars($sv['name']) . "</b></td>";
                        echo "<td>" . $sv['score'] . "</td>";
                        echo "</tr>";
                    }

                    if (!$found) {
                        echo "<tr><td colspan='3' style='color: #721c24;'>Không tìm thấy sinh viên phù hợp!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>