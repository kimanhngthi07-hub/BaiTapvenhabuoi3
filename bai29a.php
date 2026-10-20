<?php
// 1. Hàm kiểm tra điểm hợp lệ từ 0 đến 10
function isValidScore($score): bool {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

// 2. Hàm tính điểm tổng kết (10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ)
function finalScore(float $cc, float $mid, float $final): float {
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

// Khởi tạo biến giá trị để giữ lại dữ liệu khi submit lỗi
$hoTen = $_POST['hoTen'] ?? '';
$cc = $_POST['cc'] ?? '';
$mid = $_POST['mid'] ?? '';
$final = $_POST['final'] ?? '';

$ketQuaHTML = "";
$hasError = false;

if (isset($_POST['btnTinh'])) {
    // Kiểm tra không để trống
    if (trim($hoTen) === "" || $cc === "" || $mid === "" || $final === "") {
        $ketQuaHTML = '<div class="alert alert-error">Vui lòng nhập đầy đủ họ tên và các cột điểm!</div>';
        $hasError = true;
    } 
    // Kiểm tra tính hợp lệ của điểm số bằng hàm isValidScore()
    elseif (!isValidScore($cc) || !isValidScore($mid) || !isValidScore($final)) {
        $ketQuaHTML = '<div class="alert alert-error">Điểm các thành phần phải là số và nằm trong khoảng từ 0 đến 10!</div>';
        $hasError = true;
    } else {
        // Tính toán khi dữ liệu hoàn toàn hợp lệ
        $diemTongKet = finalScore((float)$cc, (float)$mid, (float)$final);
        $diemRounded = round($diemTongKet, 2);

        // Xếp loại học lực theo đúng điều kiện từ cao xuống thấp
        $xepLoai = "";
        $badgeClass = "";
        if ($diemRounded >= 8) {
            $xepLoai = "GIỎI 🏆";
            $badgeClass = "gioi";
        } elseif ($diemRounded >= 6.5) {
            $xepLoai = "KHÁ 🌟";
            $badgeClass = "kha";
        } elseif ($diemRounded >= 5) {
            $xepLoai = "TRUNG BÌNH 📖";
            $badgeClass = "tb";
        } else {
            $xepLoai = "CHƯA ĐẠT ⚠️";
            $badgeClass = "chuadat";
        }

        $ketQuaHTML = '<div class="result-box ' . $badgeClass . '">
            <b>Họ tên:</b> ' . htmlspecialchars($hoTen) . '<br>
            <b>Điểm tổng kết:</b> ' . $diemRounded . '<br>
            <b>Xếp loại:</b> ' . $xepLoai . '
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máy Tính Điểm Học Phần</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            padding: 30px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 20px; font-size: 22px; }
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
            font-weight: bold;
            text-align: center;
        }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .result-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 15px;
            line-height: 1.6;
        }
        .gioi { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .kha { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff; }
        .tb { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .chuadat { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Máy Tính Điểm Học Phần</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Họ tên sinh viên:</label>
                <input type="text" name="hoTen" placeholder="Ví dụ: Nguyễn Văn A" value="<?php echo htmlspecialchars($hoTen); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label>Điểm Chuyên Cần (10%):</label>
                <input type="text" name="cc" placeholder="0 - 10" value="<?php echo htmlspecialchars($cc); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label>Điểm Giữa Kỳ (30%):</label>
                <input type="text" name="mid" placeholder="0 - 10" value="<?php echo htmlspecialchars($mid); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label>Điểm Cuối Kỳ (60%):</label>
                <input type="text" name="final" placeholder="0 - 10" value="<?php echo htmlspecialchars($final); ?>" autocomplete="off">
            </div>

            <button type="submit" name="btnTinh">Tính điểm học phần</button>
        </form>

        <?php echo $ketQuaHTML; ?>
    </div>

</body>
</html>