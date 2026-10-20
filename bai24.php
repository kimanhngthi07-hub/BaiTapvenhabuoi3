<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 2.4 - Mảng kết hợp và foreach</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .score {
            font-weight: bold;
            color: #2e7d32;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Danh Sách Sinh Viên (Mảng Kết Hợp)</h2>
        
        <div class="rule-box">
            <b>Kiến thức:</b> Sử dụng mảng đa chiều kết hợp (mỗi phần tử là một mảng gồm <code>'name'</code> và <code>'score'</code>) và dùng vòng lặp <code>foreach</code> để duyệt dữ liệu in ra bảng.
        </div>

        <?php
        // 1. Tạo mảng chứa 3 sinh viên gồm name và score theo đúng yêu cầu slide
        $students = [
            ['name' => 'An', 'score' => 8.0],
            ['name' => 'Bình', 'score' => 6.5],
            ['name' => 'Chi', 'score' => 4.5]
        ];
        ?>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và Tên (Name)</th>
                    <th>Điểm số (Score)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                // 2. Dùng vòng lặp foreach để duyệt từng sinh viên và đổ ra các dòng trong bảng HTML
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>" . $stt++ . "</td>";
                    echo "<td><b>" . htmlspecialchars($student['name']) . "</b></td>";
                    echo "<td class='score'>" . $student['score'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>