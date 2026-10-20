<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân biệt == và === trong PHP</title>
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
        h2 { color: #333333; text-align: center; margin-bottom: 25px; font-size: 22px; }
        .rule-box {
            background: #e8f4fd;
            border-left: 5px solid #2196F3;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
            font-size: 14px;
            color: #0d47a1;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #333333;
        }
        .true { color: #2e7d32; font-weight: bold; }
        .false { color: #c62828; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h2>So sánh Toán tử `==` và `===` trong PHP</h2>
        
        <div class="rule-box">
            <b>Kiến thức cốt lõi:</b><br>
            - <code>==</code>: So sánh sau khi PHP tự động chuyển đổi kiểu dữ liệu (So sánh lỏng).<br>
            - <code>===</code>: So sánh cả giá trị VÀ kiểu dữ liệu, không đổi kiểu (So sánh chặt).
        </div>

        <table>
            <thead>
                <tr>
                    <th>Biểu thức so sánh</th>
                    <th>Giải thích chi tiết</th>
                    <th>Kết quả thực tế</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>0 == "0"</code></td>
                    <td>Số nguyên 0 so sánh lỏng với chuỗi "0"</td>
                    <td><span class="<?php echo (0 == "0") ? 'true' : 'false'; ?>"><?php echo (0 == "0") ? 'true' : 'false'; ?></span></td>
                </tr>
                <tr>
                    <td><code>0 === "0"</code></td>
                    <td>Số nguyên (int) so sánh với chuỗi (string)</td>
                    <td><span class="<?php echo (0 === "0") ? 'true' : 'false'; ?>"><?php echo (0 === "0") ? 'true' : 'false'; ?></span></td>
                </tr>
                <tr>
                    <td><code>false == 0</code></td>
                    <td>Kiểu boolean false so sánh lỏng với số 0</td>
                    <td><span class="<?php echo (false == 0) ? 'true' : 'false'; ?>"><?php echo (false == 0) ? 'true' : 'false'; ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>