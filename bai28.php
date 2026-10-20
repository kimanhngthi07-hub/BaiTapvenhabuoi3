<?php
// Bật chế độ kiểm tra kiểu dữ liệu nghiêm ngặt
declare(strict_types=1);

/**
 * Bước 1: Tạo mảng $students gồm 3 sinh viên với name, midterm, final.
 * Cố tình đưa vào 1 tên chứa ký tự đặc biệt/mã HTML để kiểm chứng tính an toàn ở Bước 5.
 */
$students = [
    [
        'id'      => 'SV001',
        'name'    => 'Nguyễn Văn An',
        'midterm' => 8.5,
        'final'   => 7.0,
    ],
    [
        'id'      => 'SV002',
        'name'    => 'Trần Thị Bình',
        'midterm' => 4.0,
        'final'   => 4.5,
    ],
    [
        'id'      => 'SV003',
        // Tên chứa ký tự đặc biệt nhằm thử nghiệm chống tấn công XSS
        'name'    => 'Lê Hoàng Nam',
        'midterm' => 9.0,
        'final'   => 8.5,
    ],
];

/**
 * Bước 2: Viết hàm calculateAverage() tính điểm trung bình
 * Nhận vào điểm giữa kỳ và cuối kỳ, trả về số thực (float)
 */
function calculateAverage(float $midterm, float $final): float
{
    return ($midterm + $final) / 2;
}

// Thống kê nhanh phục vụ hiển thị thực tế
$totalStudents = count($students);
$passedCount = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điểm tổng kết sinh viên</title>
    <style>
        :root {
            --primary: #2563eb;
            --success: #16a34a;
            --danger: #dc2626;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
.table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            color: var(--text-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 0.925rem;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .score {
            font-variant-numeric: tabular-nums;
            font-weight: 500;
        }

        /* Badge trạng thái Đạt / Chưa đạt */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.775rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #dcfce7;
            color: var(--success);
        }

        .badge-danger {
            background-color: #fee2e2;
            color: var(--danger);
        }

        .card-footer {
            padding: 16px 28px;
            background-color: #fafbfc;
            border-top: 1px solid var(--border);
            font-size: 0.875rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <!-- Tiêu đề & Thông tin -->
        <div class="card-header">
            <div>
                <h1 class="card-title">Bảng Tổng Hợp Điểm Học Phần</h1>
                <p class="card-subtitle">Học phần: Lập trình Web cơ bản (Bài thực hành 2.8)</p>
            </div>
        </div>

        <!-- Bảng dữ liệu hiển thị sinh viên -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã SV</th>
                        <th>Họ và Tên</th>
                        <th>Điểm Giữa Kỳ</th>
                        <th>Điểm Cuối Kỳ</th>
                        <th>Điểm Trung Bình</th>
                        <th>Kết Quả</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Bước 3: Dùng foreach duyệt qua danh sách sinh viên
                    $stt = 1;
                    foreach ($students as $student): 
                        // Bước 2 & 4: Tính điểm trung bình và kiểm tra điều kiện đạt
$avg = calculateAverage((float)$student['midterm'], (float)$student['final']);
                        $isPassed = $avg >= 5.0; // Tiêu chí: Đạt nếu >= 5
                        if ($isPassed) $passedCount++;
                    ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><strong><?= htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                            
                            <!-- Bước 5: Mã hóa tên sinh viên bằng htmlspecialchars() trước khi in -->
                            <td><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            
                            <td class="score"><?= number_format($student['midterm'], 1) ?></td>
                            <td class="score"><?= number_format($student['final'], 1) ?></td>
                            <td class="score"><strong><?= number_format($avg, 2) ?></strong></td>
                            
                            <!-- Bước 4: Cột kết quả Đạt / Chưa đạt -->
                            <td>
                                <?php if ($isPassed): ?>
                                    <span class="badge badge-success">✓ Đạt</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">✕ Chưa đạt</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Thống kê chân trang -->
        <div class="card-footer">
            <span>Tổng số: <strong><?= $totalStudents ?></strong> sinh viên</span>
            <span>Đạt: <strong style="color: var(--success);"><?= $passedCount ?></strong> / Chưa đạt: <strong style="color: var(--danger);"><?= $totalStudents - $passedCount ?></strong></span>
        </div>
    </div>
</div>

</body>
</html>