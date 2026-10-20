<?php
// 1. Hàm kiểm tra điểm hợp lệ từ 0 đến 10 theo đúng chuẩn bài 3
function isValidScore($score): bool {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

// 2. Hàm mã hóa output chống XSS an toàn
function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

// Khởi tạo mảng lỗi và mảng dữ liệu giữ lại (sticky form)
$errors = [];
$data = [
    'hoTen' => '',
    'cc' => '',
    'mid' => '',
    'final' => ''
];
$ketQuaHTML = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập và làm sạch dữ liệu
    $data['hoTen'] = trim($_POST['hoTen'] ?? '');
    $data['cc'] = trim($_POST['cc'] ?? '');
    $data['mid'] = trim($_POST['mid'] ?? '');
    $data['final'] = trim($_POST['final'] ?? '');

    // Validate họ tên
    if ($data['hoTen'] === '') {
        $errors['hoTen'] = 'Vui lòng không để trống họ tên sinh viên.';
    }

    // Validate điểm chuyên cần
    if ($data['cc'] === '') {
        $errors['cc'] = 'Vui lòng nhập điểm chuyên cần.';
    } elseif (!isValidScore($data['cc'])) {
        $errors['cc'] = 'Điểm chuyên cần phải là số từ 0 đến 10.';
    }

    // Validate điểm giữa kỳ
    if ($data['mid'] === '') {
        $errors['mid'] = 'Vui lòng nhập điểm giữa kỳ.';
    } elseif (!isValidScore($data['mid'])) {
        $errors['mid'] = 'Điểm giữa kỳ phải là số từ 0 đến 10.';
    }

    // Validate điểm cuối kỳ
    if ($data['final'] === '') {
        $errors['final'] = 'Vui lòng nhập điểm cuối kỳ.';
    } elseif (!isValidScore($data['final'])) {
        $errors['final'] = 'Điểm cuối kỳ phải là số từ 0 đến 10.';
    }

    // Nếu không có lỗi -> Tiến hành tính toán kết quả
    if (empty($errors)) {
        $ccVal = (float)$data['cc'];
        $midVal = (float)$data['mid'];
        $finalVal = (float)$data['final'];

        // Công thức: 10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ
        $diemTongKet = $ccVal * 0.10 + $midVal * 0.30 + $finalVal * 0.60;
        $diemRounded = round($diemTongKet, 2);

        // Xếp loại học lực
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
            <h4 style="margin-bottom: 6px;">Kết Quả Học Tập</h4>
            <b>Họ tên:</b> ' . e($data['hoTen']) . '<br>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
        }
        h2 { 
            color: #333333; 
            text-align: center; 
            margin-bottom: 25px; 
            font-size: 22px; 
        }
        .form-group { 
            margin-bottom: 16px; 
        }
        label { 
            display: block; 
            margin-bottom: 6px; 
            color: #555555; 
            font-weight: 600; 
            font-size: 14px; 
        }
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
        .input-error {
            border-color: #e53e3e !important;
            background-color: #fff5f5;
        }
        .error-msg {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
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
            <!-- Họ tên sinh viên -->
            <div class="form-group">
                <label>Họ tên sinh viên:</label>
                <input type="text" name="hoTen" 
                       class="<?php echo isset($errors['hoTen']) ? 'input-error' : ''; ?>"
                       placeholder="Ví dụ: Nguyễn Văn A" 
                       value="<?php echo e($data['hoTen']); ?>" autocomplete="off">
                <?php if (isset($errors['hoTen'])): ?>
                    <div class="error-msg"><?php echo $errors['hoTen']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Điểm Chuyên Cần -->
            <div class="form-group">
                <label>Điểm Chuyên Cần (10%):</label>
                <input type="text" name="cc" 
                       class="<?php echo isset($errors['cc']) ? 'input-error' : ''; ?>"
                       placeholder="0 - 10" 
                       value="<?php echo e($data['cc']); ?>" autocomplete="off">
                <?php if (isset($errors['cc'])): ?>
                    <div class="error-msg"><?php echo $errors['cc']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Điểm Giữa Kỳ -->
            <div class="form-group">
                <label>Điểm Giữa Kỳ (30%):</label>
                <input type="text" name="mid" 
                       class="<?php echo isset($errors['mid']) ? 'input-error' : ''; ?>"
                       placeholder="0 - 10" 
                       value="<?php echo e($data['mid']); ?>" autocomplete="off">
                <?php if (isset($errors['mid'])): ?>
                    <div class="error-msg"><?php echo $errors['mid']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Điểm Cuối Kỳ -->
            <div class="form-group">
                <label>Điểm Cuối Kỳ (60%):</label>
                <input type="text" name="final" 
                       class="<?php echo isset($errors['final']) ? 'input-error' : ''; ?>"
                       placeholder="0 - 10" 
                       value="<?php echo e($data['final']); ?>" autocomplete="off">
                <?php if (isset($errors['final'])): ?>
                    <div class="error-msg"><?php echo $errors['final']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Tính điểm học phần</button>
        </form>

        <?php echo $ketQuaHTML; ?>
    </div>

</body>
</html>