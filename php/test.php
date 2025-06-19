<?php
$conn = new mysqli('localhost', 'root', '', 'webcomnha2');
$conn->set_charset("utf8");

$stmt = $conn->prepare("INSERT INTO users (hoten, email, sdt, matkhau, role, created_at) VALUES (?, ?, ?, ?, 'nhanvien', NOW())");
$hoten = 'Test';
$email = 'test@example.com';
$sdt = '0123456789';
$matkhau = password_hash('123456', PASSWORD_DEFAULT);

$stmt->bind_param("ssss", $hoten, $email, $sdt, $matkhau);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Tạo thành công!";
} else {
    echo "Lỗi: " . $stmt->error;
}
