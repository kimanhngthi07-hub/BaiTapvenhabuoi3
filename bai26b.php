<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tiền tài liệu</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 25px; font-size: 22px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 6px; color: #555555; font-weight: 600; font-size: 14px; }
        input[type="text"], input[type="number"] {
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
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        button:hover { background-color: #357abd; }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            text-align: center;
        }
        .error {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Tính Tiền Tài Liệu</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="tenTaiLieu">Tên tài liệu:</label>
                <input type="text" id="tenTaiLieu" name="tenTaiLieu" placeholder="Ví dụ: Lập trình web" autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="soLuong">Số lượng:</label>
                <input type="number" id="soLuong" name="soLuong" placeholder="Ví dụ: 2" min="1">
            </div>

            <div class="form-group">
                <label for="donGia">Đơn giá (VNĐ):</label>
                <input type="number" id="donGia" name="donGia" placeholder="Ví dụ: 100000" min="0">
            </div>

            <button type="submit" name="btnTinh">Tính</button>
        </form>

        <?php
        if (isset($_POST['btnTinh'])) {
            $tenTaiLieu = trim($_POST['tenTaiLieu']);
            $soLuong = trim($_POST['soLuong']);
            $donGia = trim($_POST['donGia']);

            // Kiểm tra dữ liệu hợp lệ
            if ($tenTaiLieu === "" || $soLuong === "" || $donGia === "") {
                echo '<div class="error">Vui lòng nhập đầy đủ Tên tài liệu, Số lượng và Đơn giá!</div>';
            } elseif (!is_numeric($soLuong) || !is_numeric($donGia) || $soLuong <= 0 || $donGia < 0) {
                echo '<div class="error">Số lượng và đơn giá phải là số hợp lệ lớn hơn 0!</div>';
            } else {
                // Tính tổng tiền
                $thanhTien = (float)$soLuong * (float)$donGia;
                
                // Định dạng hiển thị tiền tệ chuẩn Việt Nam (ví dụ: 200.000)
                $tienFormatted = number_format($thanhTien, 0, ',', '.');

                // Hiển thị kết quả đúng định dạng đề bài yêu cầu
                echo '<div class="result">' . htmlspecialchars($tenTaiLieu) . ': ' . $tienFormatted . ' đ</div>';
            }
        }
        ?>
    </div>

</body>
</html>