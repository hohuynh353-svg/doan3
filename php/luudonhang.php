<?php
session_start();
require 'connect.php'; // Kết nối MySQLi

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit;
}

$userId = $_SESSION['user_id'];
$donhang = $_SESSION['donhang'] ?? [];

if (empty($donhang)) {
    echo "Không có món nào để đặt hàng.";
    exit;
}

// Lưu địa chỉ vào session
$_SESSION['diachi'] = [
    'sonha' => $_POST['sonha'],
    'duong' => $_POST['duong'],
    'phuong' => $_POST['phuong'],
    'quan' => $_POST['quan'],
    'thanhpho' => $_POST['thanhpho'],
];

// Tính tổng tiền gốc
$tongtien = 0;
foreach ($donhang as $mon) {
    $tongtien += $mon['gia'] * $mon['soluong'];
}

// Ghi chú và ưu đãi
$ghichu = $_POST['ghichu'] ?? '';
$uudai = $_POST['uudai'] ?? 0;

// Lấy điểm tích lũy hiện tại
$stmt = $conn->prepare("SELECT diemtichluy FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$diemHienTai = (int) $user['diemtichluy'];

// Tính giảm giá
$phanTramGiam = 0;
$diemCanTru = 0;

if ($uudai == 15 && $diemHienTai >= 10) {
    $phanTramGiam = 15;
    $diemCanTru = 10;
} elseif ($uudai == 30 && $diemHienTai >= 20) {
    $phanTramGiam = 30;
    $diemCanTru = 20;
} elseif ($uudai == 50 && $diemHienTai >= 30) {
    $phanTramGiam = 50;
    $diemCanTru = 30;
}

if ($phanTramGiam > 0) {
    $tongtien = round($tongtien * (1 - $phanTramGiam / 100));
}

// Lưu đơn hàng vào bảng `donhang`
$stmt = $conn->prepare("INSERT INTO donhang (user_id, tongtien, ghichu, trangthai, thoigian, sonha, duong, phuong, quan, thanhpho)
VALUES (?, ?, ?, 'Chờ xử lý', NOW(), ?, ?, ?, ?, ?)");
$stmt->bind_param("iissssss",
    $userId,
    $tongtien,
    $ghichu,
    $_POST['sonha'],
    $_POST['duong'],
    $_POST['phuong'],
    $_POST['quan'],
    $_POST['thanhpho']
);
$stmt->execute();
$donhang_id = $conn->insert_id;

// Lưu từng món vào bảng `chitiet_donhang`
$stmt_ct = $conn->prepare("INSERT INTO chitiet_donhang (id_donhang, tenmon, soluong, gia, thanhtien) VALUES (?, ?, ?, ?, ?)");
foreach ($donhang as $mon) {
    $tenmon = $mon['tenmon'];
    $soluong = $mon['soluong'];
    $gia = $mon['gia'];
    $thanhtien = $gia * $soluong;

    $stmt_ct->bind_param("isiii", $donhang_id, $tenmon, $soluong, $gia, $thanhtien);
    $stmt_ct->execute();
}

// Cập nhật điểm tích lũy
if ($phanTramGiam > 0) {
    $stmt_diem = $conn->prepare("UPDATE users SET diemtichluy = diemtichluy - ? WHERE id = ?");
    $stmt_diem->bind_param("ii", $diemCanTru, $userId);
    $stmt_diem->execute();
} else {
    $diemCong = 1;
    $stmt_diem = $conn->prepare("UPDATE users SET diemtichluy = diemtichluy + ? WHERE id = ?");
    $stmt_diem->bind_param("ii", $diemCong, $userId);
    $stmt_diem->execute();
}

// Xoá giỏ hàng
unset($_SESSION['donhang']);

// Chuyển đến trang xác nhận
header("Location: diemkhachhang.php?donhang_id=$donhang_id");
exit;
