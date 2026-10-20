<?php
// Định dạng tiền tệ theo đúng mẫu trong slide
function money(float $value): string {
    return number_format($value, 0, ',', '.') . ' đ';
}

// Đọc dữ liệu POST và ép kiểu an toàn
$name = $_POST['name'] ?? '';
$qty = (int)($_POST['qty'] ?? 0);
$price = (float)($_POST['price'] ?? 0);
$total = $qty * $price;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo 2.7 - Hóa đơn học liệu</title>
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
            margin-top: 5px;
        }
        button:hover { background-color: #357abd; }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Hóa Đơn Học Liệu</h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Tên tài liệu:</label>
                <input type="text" name="name" placeholder="Nhập tên tài liệu" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Số lượng:</label>
                <input type="number" name="qty" placeholder="Nhập số lượng" min="1" value="<?php echo $qty > 0 ? $qty : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Đơn giá:</label>
                <input type="number" name="price" placeholder="Nhập đơn giá" min="0" step="any" value="<?php echo $price > 0 ? $price : ''; ?>" required>
            </div>

            <button type="submit">Tính</button>
        </form>

        <?php if ($total > 0): ?>
            <div class="result">
                <?php echo htmlspecialchars($name); ?>: <?php echo money($total); ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>