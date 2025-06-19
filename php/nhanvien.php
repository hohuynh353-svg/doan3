<?php
// index.php - Trang chính quản lý ca làm việc

// Dữ liệu mẫu (trong thực tế sẽ lấy từ database)
$employees = [
    ['id' => 1, 'name' => 'Nguyễn Văn An', 'position' => 'Nhân viên bán hàng'],
    ['id' => 2, 'name' => 'Trần Thị Bình', 'position' => 'Thu ngân'],
    ['id' => 3, 'name' => 'Lê Văn Cường', 'position' => 'Bảo vệ'],
    ['id' => 4, 'name' => 'Phạm Thị Dung', 'position' => 'Quản lý'],
];

$shifts = [
    ['id' => 1, 'employee_id' => 1, 'date' => '2024-12-15', 'start_time' => '08:00', 'end_time' => '16:00', 'status' => 'Đã hoàn thành'],
    ['id' => 2, 'employee_id' => 2, 'date' => '2024-12-15', 'start_time' => '16:00', 'end_time' => '22:00', 'status' => 'Đã hoàn thành'],
    ['id' => 3, 'employee_id' => 1, 'date' => '2024-12-16', 'start_time' => '08:00', 'end_time' => '16:00', 'status' => 'Đang làm việc'],
    ['id' => 4, 'employee_id' => 3, 'date' => '2024-12-16', 'start_time' => '22:00', 'end_time' => '06:00', 'status' => 'Chưa bắt đầu'],
];

// Xử lý form submit
if ($_POST) {
    if (isset($_POST['add_shift'])) {
        // Thêm ca làm việc mới
        $new_shift = [
            'id' => count($shifts) + 1,
            'employee_id' => $_POST['employee_id'],
            'date' => $_POST['date'],
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'status' => 'Chưa bắt đầu'
        ];
        array_push($shifts, $new_shift);
        $success_message = "Đã thêm ca làm việc thành công!";
    }
}

// Hàm lấy tên nhân viên theo ID
function getEmployeeName($employee_id, $employees) {
    foreach ($employees as $emp) {
        if ($emp['id'] == $employee_id) {
            return $emp['name'];
        }
    }
    return 'Không xác định';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Ca làm việc</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(45deg, #2196F3, #21CBF3);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .main-content {
            padding: 30px;
        }

        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 3px solid #e0e0e0;
        }

        .tab {
            flex: 1;
            padding: 15px 20px;
            background: #f5f5f5;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab.active {
            background: #2196F3;
            color: white;
        }

        .tab:hover {
            background: #1976D2;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 10px rgba(33, 150, 243, 0.3);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(45deg, #2196F3, #21CBF3);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(33, 150, 243, 0.4);
        }

        .btn-success {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(45deg, #FF9800, #F57C00);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: linear-gradient(45deg, #2196F3, #21CBF3);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-completed {
            background: #4CAF50;
            color: white;
        }

        .status-working {
            background: #FF9800;
            color: white;
        }

        .status-pending {
            background: #9E9E9E;
            color: white;
        }

        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: bold;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .stat-card i {
            font-size: 3em;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .stat-card h3 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .tabs {
                flex-direction: column;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-clock"></i> Quản lý Ca làm việc</h1>
            <p>Hệ thống quản lý lịch làm việc nhân viên</p>
        </div>

        <div class="main-content">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo count($employees); ?></h3>
                    <p>Tổng nhân viên</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3><?php echo count($shifts); ?></h3>
                    <p>Tổng ca làm việc</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <h3><?php echo count(array_filter($shifts, function($s) { return $s['status'] == 'Đang làm việc'; })); ?></h3>
                    <p>Đang làm việc</p>
                </div>
            </div>

            <div class="tabs">
                <button class="tab active" onclick="showTab('shifts')">
                    <i class="fas fa-list"></i> Danh sách ca làm việc
                </button>
                <button class="tab" onclick="showTab('add-shift')">
                    <i class="fas fa-plus"></i> Thêm ca làm việc
                </button>
                <button class="tab" onclick="showTab('employees')">
                    <i class="fas fa-users"></i> Quản lý nhân viên
                </button>
            </div>

            <!-- Tab Danh sách ca làm việc -->
            <div id="shifts" class="tab-content active">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Nhân viên</th>
                                <th><i class="fas fa-calendar"></i> Ngày</th>
                                <th><i class="fas fa-clock"></i> Giờ bắt đầu</th>
                                <th><i class="fas fa-clock"></i> Giờ kết thúc</th>
                                <th><i class="fas fa-info-circle"></i> Trạng thái</th>
                                <th><i class="fas fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shifts as $shift): ?>
                            <tr>
                                <td><?php echo $shift['id']; ?></td>
                                <td><?php echo getEmployeeName($shift['employee_id'], $employees); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($shift['date'])); ?></td>
                                <td><?php echo $shift['start_time']; ?></td>
                                <td><?php echo $shift['end_time']; ?></td>
                                <td>
                                    <span class="status-badge 
                                        <?php 
                                        if ($shift['status'] == 'Đã hoàn thành') echo 'status-completed';
                                        elseif ($shift['status'] == 'Đang làm việc') echo 'status-working';
                                        else echo 'status-pending';
                                        ?>">
                                        <?php echo $shift['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Thêm ca làm việc -->
            <div id="add-shift" class="tab-content">
                <form method="POST" action="">
                    <div class="form-grid">
                        <div>
                            <div class="form-group">
                                <label for="employee_id">
                                    <i class="fas fa-user"></i> Chọn nhân viên
                                </label>
                                <select name="employee_id" id="employee_id" required>
                                    <option value="">-- Chọn nhân viên --</option>
                                    <?php foreach ($employees as $emp): ?>
                                    <option value="<?php echo $emp['id']; ?>">
                                        <?php echo $emp['name']; ?> - <?php echo $emp['position']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="date">
                                    <i class="fas fa-calendar"></i> Ngày làm việc
                                </label>
                                <input type="date" name="date" id="date" required>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label for="start_time">
                                    <i class="fas fa-clock"></i> Giờ bắt đầu
                                </label>
                                <input type="time" name="start_time" id="start_time" required>
                            </div>

                            <div class="form-group">
                                <label for="end_time">
                                    <i class="fas fa-clock"></i> Giờ kết thúc
                                </label>
                                <input type="time" name="end_time" id="end_time" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="add_shift" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm ca làm việc
                    </button>
                </form>
            </div>

            <!-- Tab Quản lý nhân viên -->
            <div id="employees" class="tab-content">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Họ tên</th>
                                <th><i class="fas fa-briefcase"></i> Chức vụ</th>
                                <th><i class="fas fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $emp): ?>
                            <tr>
                                <td><?php echo $emp['id']; ?></td>
                                <td><?php echo $emp['name']; ?></td>
                                <td><?php echo $emp['position']; ?></td>
                                <td>
                                    <button class="btn btn-warning" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Ẩn tất cả tab content
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Bỏ active khỏi tất cả tab buttons
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });

            // Hiển thị tab được chọn
            document.getElementById(tabName).classList.add('active');
            
            // Thêm active cho tab button được click
            event.target.classList.add('active');
        }

        // Tự động cập nhật ngày hiện tại cho form
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });

        // Xác nhận trước khi xóa
        document.querySelectorAll('.btn-danger').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Bạn có chắc chắn muốn xóa không?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>