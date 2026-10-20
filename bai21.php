<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực hành PHP - Kiểm tra điểm hợp lệ</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555555;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 15px;
        }
        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #218838;
        }
        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Kiểm Tra Điểm Hợp Lệ (0 - 10)</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="diem">Nhập vào số điểm cần kiểm tra:</label>
                <input type="text" id="diem" name="diem" placeholder="Ví dụ: 7.5">
            </div>
            <button type="submit" name="btnKiemTra">Kiểm tra ngay</button>
        </form>

        <?php
        // Kiểm tra xem người dùng đã bấm nút submit hay chưa
        if (isset($_POST['btnKiemTra'])) {
            $diem = trim($_POST['diem']);

            // Biểu thức kiểm tra điều kiện theo đúng yêu cầu slide: 
            // Là số (is_numeric) VÀ nằm trong khoảng từ 0 đến 10
            if ($diem === "") {
                echo '<div class="alert alert-error">Vui lòng không để trống ô nhập điểm!</div>';
            } elseif (is_numeric($diem) && $diem >= 0 && $diem <= 10) {
                echo '<div class="alert alert-success">Điểm hợp lệ: <b>' . htmlspecialchars($diem) . '</b></div>';
            } else {
                echo '<div class="alert alert-error">Điểm không hợp lệ! Yêu cầu phải là số từ 0 đến 10.</div>';
            }
        }
        ?>
    </div>

</body>
</html>