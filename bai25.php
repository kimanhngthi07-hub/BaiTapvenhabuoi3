<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 2.5 - Hàm tính điểm tổng kết</title>
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
            max-width: 450px;
        }
        h2 { color: #333333; text-align: center; margin-bottom: 20px; font-size: 22px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555555; font-weight: 600; font-size: 14px; }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
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
            margin-top: 5px;
        }
        button:hover { background-color: #357abd; }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            background-color: #e8f4fd;
            color: #0d47a1;
            border: 1px solid #b8daff;
        }
        .error {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Tính Điểm Tổng Kết Môn Học</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="cc">Điểm Chuyên Cần (10%):</label>
                <input type="text" id="cc" name="cc" placeholder="Ví dụ: 9.0" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="mid">Điểm Giữa Kỳ (30%):</label>
                <input type="text" id="mid" name="mid" placeholder="Ví dụ: 7.5" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="final">Điểm Cuối Kỳ (60%):</label>
                <input type="text" id="final" name="final" placeholder="Ví dụ: 8.0" autocomplete="off">
            </div>
            <button type="submit" name="btnTinh">Tính điểm tổng kết</button>
        </form>

        <?php
        // Định nghĩa hàm finalScore theo đúng yêu cầu và mẫu trong slide[cite: 15]
        function finalScore(float $cc, float $mid, float $final): float
        {
            return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
        }

        if (isset($_POST['btnTinh'])) {
            $cc = trim($_POST['cc']);
            $mid = trim($_POST['mid']);
            $final = trim($_POST['final']);

            // Kiểm tra tính hợp lệ của dữ liệu đầu vào
            if ($cc === "" || $mid === "" || $final === "") {
                echo '<div class="error">Vui lòng không để trống các ô nhập điểm!</div>';
            } elseif (!is_numeric($cc) || !is_numeric($mid) || !is_numeric($final)) {
                echo '<div class="error">Tất cả các điểm nhập vào phải là số!</div>';
            } else {
                $cc = (float)$cc;
                $mid = (float)$mid;
                $final = (float)$final;

                if ($cc < 0 || $cc > 10 || $mid < 0 || $mid > 10 || $final < 0 || $final > 10) {
                    echo '<div class="error">Các điểm số phải nằm trong khoảng từ 0 đến 10!</div>';
                } else {
                    // Gọi hàm tính điểm tổng kết
                    $tongKet = finalScore($cc, $mid, $final);
                    $tongKetFormatted = round($tongKet, 2);

                    echo '<div class="result">Điểm tổng kết của bạn là: <b>' . $tongKetFormatted . '</b> 🎓</div>';
                }
            }
        }
        ?>
    </div>

</body>
</html>