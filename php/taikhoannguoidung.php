<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dangnhap.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT hoten, email, sdt, diemtichluy, role, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .flex-container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            margin-right: 30px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            background: #f5f5f5;
            color: black;
            border-radius: 5px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar .active {
            background: #e0e0e0;
            font-weight: bold;
        }
        .content-box {
            flex: 1;
            background: #fafafa;
            padding: 20px;
            border-radius: 10px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .btn-edit {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .security-section {
            margin-top: 40px;
        }
    </style>
    <link rel="stylesheet" href="../css/taikhoannguoidung.css">
</head>
<body>

<div class="main-container">
    <div class="section-title">Quản lý tài khoản</div>
    <div class="flex-container">
        <div class="sidebar">
            <ul>
                <li><a href="#" class="active">Thông tin cá nhân</a></li>
                <li><a href="#">Đổi mật khẩu</a></li>
                <li><a href="donhang_cuatoi.php">Đơn hàng của tôi </a></li>
               
            </ul>
        </div>

        <div class="content-box">
            <h3>Thông tin cá nhân</h3>
            <div class="info-row"><span class="info-label">Họ và tên:</span> <?= htmlspecialchars($user['hoten']) ?></div>
            <div class="info-row"><span class="info-label">Email:</span> <?= htmlspecialchars($user['email']) ?></div>
            <div class="info-row"><span class="info-label">Số điện thoại:</span> <?= htmlspecialchars($user['sdt']) ?></div>
            <div class="info-row"><span class="info-label">Điểm tích lũy:</span> <?= number_format($user['diemtichluy']) ?> điểm</div>
            <div class="info-row"><span class="info-label">Vai trò:</span> <?= htmlspecialchars($user['role']) ?></div>
            <div class="info-row"><span class="info-label">Ngày tham gia:</span> <?= date('d/m/Y', strtotime($user['created_at'])) ?></div>

           
           
        </div>
    </div>

    <div class="security-section">
        <h3>Bảo mật</h3>
        <p>Để bảo vệ tài khoản của bạn, vui lòng sử dụng mật khẩu mạnh và không chia sẻ với người khác.</p>
        <a href="index.php" class="back-btn">⬅ Quay lại</a>
    </div>
</div>

</body>
</html>
