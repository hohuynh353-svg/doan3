<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sonha'])) {
    $_SESSION['diachi'] = [
        'sonha' => $_POST['sonha'],
        'duong' => $_POST['duong'],
        'phuong' => $_POST['phuong'],
        'quan' => $_POST['quan'],
        'thanhpho' => $_POST['thanhpho'],
    ];

    // Tránh lỗi gửi lại khi F5
    header("Location: xemdonhang.php");
    exit;
}

require 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit;
}

$donhang = $_SESSION['donhang'] ?? [];

if (empty($donhang)) {
    echo "Giỏ hàng trống.";
    exit;
}

// Lấy thông tin user
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT hoten, email, sdt, diemtichluy FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$diachi = $_SESSION['diachi'] ?? null;

// Tính tổng tiền
$tamtinh = 0;
foreach ($donhang as $mon) {
    $tamtinh += $mon['gia'] * $mon['soluong'];
}
$tongcong = $tamtinh;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }

        .container {
            display: flex;
            gap: 20px;
            max-width: 1100px;
            margin: auto;
        }

        .box {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .item:last-child {
            border-bottom: none;
        }

        .total {
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
        }

        .label {
            font-weight: bold;
            margin-top: 10px;
        }

        .info {
            margin-bottom: 5px;
        }

        .form-group {
            margin-top: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #444;
        }

        .form-group input[type="radio"] {
            margin-right: 6px;
        }

        .submit-btn {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .disabled {
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Thông tin đơn hàng -->
        <div class="box">
            <h2>🧾 Tóm Tắt Đơn Hàng</h2>
            <?php foreach ($donhang as $mon): ?>
                <div class="item">
                    <?= $mon['tenmon'] ?> (x<?= $mon['soluong'] ?>)<br>
                    <?= number_format($mon['gia']) ?>đ
                </div>
            <?php endforeach; ?>
            <div class="total">Tổng cộng: <?= number_format($tongcong) ?>đ</div>
        </div>

        <!-- Thông tin khách hàng + điểm + phương thức -->
        <div class="box">
            <h2>👤 Thông Tin Khách Hàng</h2>
            <div class="info">Họ tên: <?= htmlspecialchars($user['hoten']) ?></div>
            <div class="info">Email: <?= htmlspecialchars($user['email']) ?></div>
            <div class="info">SĐT: <?= htmlspecialchars($user['sdt']) ?></div>
            <?php if ($diachi): ?>
                <div class="label">📍 Địa chỉ nhận hàng:</div>
                <div class="info">
                    <?= htmlspecialchars($diachi['sonha']) ?>, <?= htmlspecialchars($diachi['duong']) ?>,<br>
                    <?= htmlspecialchars($diachi['phuong']) ?>, <?= htmlspecialchars($diachi['quan']) ?>,<br>
                    <?= htmlspecialchars($diachi['thanhpho']) ?>
                </div>
            <?php endif; ?>

            <div class="label">⭐ Điểm Tích Lũy: <?= $user['diemtichluy'] ?> điểm</div>

            <form method="POST" action="luudonhang.php">
                <!-- Gửi địa chỉ ẩn -->
                <?php if ($diachi): ?>
                    <input type="hidden" name="sonha" value="<?= htmlspecialchars($diachi['sonha']) ?>">
                    <input type="hidden" name="duong" value="<?= htmlspecialchars($diachi['duong']) ?>">
                    <input type="hidden" name="phuong" value="<?= htmlspecialchars($diachi['phuong']) ?>">
                    <input type="hidden" name="quan" value="<?= htmlspecialchars($diachi['quan']) ?>">
                    <input type="hidden" name="thanhpho" value="<?= htmlspecialchars($diachi['thanhpho']) ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>🎁 Chọn ưu đãi muốn áp dụng:</label>
                    <label><input type="radio" name="uudai" value="15" <?= $user['diemtichluy'] >= 10 ? '' : 'disabled' ?>> Giảm 15% (10 điểm)</label>
                    <label><input type="radio" name="uudai" value="30" <?= $user['diemtichluy'] >= 20 ? '' : 'disabled' ?>> Giảm 30% (20 điểm)</label>
                    <label><input type="radio" name="uudai" value="50" <?= $user['diemtichluy'] >= 30 ? '' : 'disabled' ?>> Giảm 50% (30 điểm)</label>
                </div>

                <div class="form-group">
                    <label>💳 Phương thức thanh toán:</label>
                    <label><input type="radio" name="thanhtoan" value="cod" checked> Thanh toán khi nhận hàng (COD)</label>
                    <label><input type="radio" name="thanhtoan" value="bank"> Chuyển khoản ngân hàng</label>
                </div>

                <button class="submit-btn" type="submit">🔒 XÁC NHẬN THANH TOÁN</button>
            </form>
        </div>
    </div>
</body>
</html>
