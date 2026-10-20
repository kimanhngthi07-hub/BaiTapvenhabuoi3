<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 2.3 - Xếp loại học lực</title>
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
            max-width: 420px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 20px; font-size: 22px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555555; font-weight: 600; }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 16px;
        }
        input[type="text"]:focus {
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
        }
        button:hover { background-color: #357abd; }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }
        .gioi { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .kha { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff; }
        .tb { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .chuadat { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Xếp Loại Học Lực</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="diem">Nhập số điểm tổng kết (0 - 10):</label>
                <input type="text" id="diem" name="diem" placeholder="Ví dụ: 7.5" autocomplete="off">
            </div>
            <button type="submit" name="btnXepLoai">Xếp loại ngay</button>
        </form>

        <?php
        if (isset($_POST['btnXepLoai'])) {
            $diem = trim($_POST['diem']);

            if ($diem === "" || !is_numeric($diem)) {
                echo '<div class="result chuadat">Vui lòng nhập vào một số hợp lệ!</div>';
            } else {
                $diem = (float)$diem;
                if ($diem < 0 || $diem > 10) {
                    echo '<div class="result chuadat">Điểm phải nằm trong khoảng từ 0 đến 10!</div>';
                } else {
                    // Thuật toán điều kiện từ cao xuống thấp theo đúng hướng dẫn trong slide
                    if ($diem >= 8) {
                        echo '<div class="result gioi">Điểm: ' . $diem . ' - Xếp loại: GIỎI 🏆</div>';
                    } elseif ($diem >= 6.5) {
                        echo '<div class="result kha">Điểm: ' . $diem . ' - Xếp loại: KHÁ 🌟</div>';
                    } elseif ($diem >= 5) {
                        echo '<div class="result tb">Điểm: ' . $diem . ' - Xếp loại: TRUNG BÌNH 📖</div>';
                    } else {
                        echo '<div class="result chuadat">Điểm: ' . $diem . ' - Xếp loại: CHƯA ĐẠT ⚠️</div>';
                    }
                }
            }
        }
        ?>
    </div>

</body>
</html>