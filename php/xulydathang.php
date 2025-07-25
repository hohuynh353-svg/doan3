<?php
session_start();
require 'connect.php';

if (empty($_SESSION['donhang'])) {
    die("Không có đơn hàng để xử lý.");
}

$cart = $_SESSION['donhang'];
$hoten = $_POST['hoten'] ?? '';
$sdt = $_POST['sdt'] ?? '';
$sonha = $_POST['sonha'] ?? '';
$duong = $_POST['duong'] ?? '';
$phuong = $_POST['phuong'] ?? '';
$quan = $_POST['quan'] ?? '';
$thanhpho = $_POST['thanhpho'] ?? '';
$ghichu = $_POST['ghichu'] ?? '';
$tongtien = 0;
foreach ($cart as $mon) {
    $tongtien += $mon['gia'] * $mon['soluong'];
}

$user_id = $_SESSION['user_id'] ?? null;

// 1. Thêm vào bảng donhang
$sql = "INSERT INTO donhang (user_id, hoten, sdt, tongtien, ghichu, sonha, duong, phuong, quan, thanhpho) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ississssss", $user_id, $hoten, $sdt, $tongtien, $ghichu, $sonha, $duong, $phuong, $quan, $thanhpho);

if (!$stmt->execute()) {
    die("❌ Lỗi thêm đơn hàng: " . $stmt->error);
}

$id_donhang = $conn->insert_id; // lấy id đơn hàng vừa thêm

// 2. Thêm từng món vào bảng chitiet_donhang
foreach ($cart as $mon) {
    $tenmon = $mon['tenmon'];
    $soluong = $mon['soluong'];
    $gia = $mon['gia'];
    $thanhtien = $gia * $soluong;

    $stmt_ct = $conn->prepare("INSERT INTO chitiet_donhang (id_donhang, tenmon, soluong, gia, thanhtien) VALUES (?, ?, ?, ?, ?)");
    $stmt_ct->bind_param("isidd", $id_donhang, $tenmon, $soluong, $gia, $thanhtien);
    $stmt_ct->execute();
}

// 3. Xoá giỏ hàng khỏi session
unset($_SESSION['donhang']);

// 4. Lưu thông tin đơn hàng vào session để hiển thị lại
$_SESSION['thongtin_donhang'] = [
    'hoten' => $hoten,
    'sdt' => $sdt,
    'diachi' => "$sonha, $duong, $phuong, $quan, $thanhpho",
    'tongtien' => $tongtien,
    'danhsach_mon' => $cart
];

// 5. Chuyển hướng tới trang xác nhận
header("Location: dathangthanhcong.php");
exit();
?>
