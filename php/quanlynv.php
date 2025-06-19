<?php
include 'connect.php';
date_default_timezone_set('Asia/Ho_Chi_Minh'); // ✅ Set múi giờ về Việt Nam

// Lấy dữ liệu từ form
$tennv = $_POST['tennv'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];
$diachi = $_POST['diachi'];
$chucvu = $_POST['chucvu'];
$gioitinh = $_POST['gioitinh'];
$ngaytao = date('Y-m-d H:i:s');

// Câu lệnh SQL để thêm nhân viên
$sql = "INSERT INTO nhanvien (tennv, email, sdt, diachi, chucvu, gioitinh, ngaytao)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $tennv, $email, $sdt, $diachi, $chucvu, $gioitinh, $ngaytao);

if ($stmt->execute()) {
    echo "Thêm nhân viên thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
