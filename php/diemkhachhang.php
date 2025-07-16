<?php
session_start();
require 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit;
}

$userId = $_SESSION['user_id'];
$donhang_id = $_GET['donhang_id'] ?? null;

if (!$donhang_id) {
    echo "Thiếu mã đơn hàng.";
    exit;
}

// Lấy thông tin khách hàng
$stmt = $conn->prepare("SELECT hoten, email, diemtichluy FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Lấy địa chỉ giao hàng từ đơn hàng
$stmt = $conn->prepare("SELECT sonha, duong, phuong, quan, thanhpho FROM donhang WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $donhang_id, $userId);
$stmt->execute();
$diachi = $stmt->get_result()->fetch_assoc();

// Lấy thông tin đơn hàng chính
$stmt = $conn->prepare("SELECT trangthai, thoigian, ghichu, tongtien FROM donhang WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $donhang_id, $userId);
$stmt->execute();
$donhang = $stmt->get_result()->fetch_assoc();

if (!$donhang) {
    echo "Không tìm thấy đơn hàng.";
    exit;
}

// Lấy chi tiết món ăn trong đơn hàng
$stmt = $conn->prepare("SELECT tenmon, soluong, gia, thanhtien FROM chitiet_donhang WHERE id_donhang = ?");
$stmt->bind_param("i", $donhang_id);
$stmt->execute();
$ct_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }
        .order-confirmation {
            position: relative; 
            background: #fff;
            border-radius: 10px;
            padding: 25px 30px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        h2 {
            color: #28a745;
            text-align: center;
        }
        .section {
            margin-top: 25px;
        }
        .section-title {
            font-weight: bold;
            color: #007bff;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .info p {
            margin: 4px 0;
        }
        .info span {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        .highlight {
            color: #28a745;
            font-weight: bold;
        }
        .note {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
            background: #e9fce9;
            padding: 10px;
            border-left: 4px solid #28a745;
        }
        /* nút đóng */
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 30px;
  color: #ff1900ff;
  cursor: pointer;
  transition: color 0.2s ease;
  z-index: 10;
}


        
    </style>
</head>
<body>

<div class="order-confirmation">
    <div class="close-btn" onclick="window.location.href='index.php'">&times;</div>

    <h2>✅ Quý khách đã đặt hàng thành công!</h2>

    <div class="section">
        <div class="section-title">👤 Thông Tin Khách Hàng</div>
        <div class="info">
            <p><span>Họ tên:</span> <?= htmlspecialchars($user['hoten']) ?></p>
            <p><span>Email:</span> <?= htmlspecialchars($user['email']) ?></p>

            <?php
            $hasAddress = isset($diachi['sonha'], $diachi['duong'], $diachi['phuong'], $diachi['quan'], $diachi['thanhpho']) &&
                        $diachi['sonha'] && $diachi['duong'] && $diachi['phuong'] && $diachi['quan'] && $diachi['thanhpho'];
            ?>

            <?php if ($hasAddress): ?>
                <p><span>Địa chỉ:</span>
                    <?= htmlspecialchars($diachi['sonha']) ?>,
                    <?= htmlspecialchars($diachi['duong']) ?>,
                    <?= htmlspecialchars($diachi['phuong']) ?>,
                    <?= htmlspecialchars($diachi['quan']) ?>,
                    <?= htmlspecialchars($diachi['thanhpho']) ?>
                </p>
            <?php else: ?>
                <p><span>Địa chỉ:</span> <i style="color: gray;">Chưa có</i></p>
            <?php endif; ?>

            <p><span>Điểm tích lũy hiện tại:</span> <span class="highlight"><?= $user['diemtichluy'] ?> điểm</span></p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">📦 Thông Tin Đơn Hàng</div>
        <div class="info">
            <p><span>Mã đơn hàng:</span> <?= $donhang_id ?></p>
            <p><span>Trạng thái:</span> <?= htmlspecialchars($donhang['trangthai']) ?></p>
            <p><span>Thời gian:</span> <?= htmlspecialchars($donhang['thoigian']) ?></p>
            <p><span>Ghi chú:</span> <?= $donhang['ghichu'] ? htmlspecialchars($donhang['ghichu']) : 'Không có' ?></p>
            <p><span>Tổng tiền:</span> <span class="highlight"><?= number_format($donhang['tongtien'], 0, ',', '.') ?>đ</span></p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">🍽 Chi Tiết Món Ăn</div>
        <table>
            <thead>
                <tr>
                    <th>Món ăn</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $ct_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['tenmon']) ?></td>
                        <td><?= $row['soluong'] ?></td>
                        <td><?= number_format($row['gia'], 0, ',', '.') ?>đ</td>
                        <td><?= number_format($row['thanhtien'], 0, ',', '.') ?>đ</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="note">
        ✅ Bạn đã được cộng thêm <strong>1 điểm</strong> vào tài khoản nếu không sử dụng ưu đãi.
        <br>🎁 Nếu bạn đã dùng ưu đãi, điểm đã được trừ tương ứng và tổng tiền đã giảm.
    </div>
</div>

</body>
</html>
