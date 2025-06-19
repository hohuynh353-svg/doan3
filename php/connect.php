<?php
$server = 'localhost';
$user = 'root';
$pass = ''; // Không có khoảng trắng ở đây!
$database = 'webcomnha2';

// Tạo kết nối
$conn = new mysqli($server, $user, $pass, $database);
$conn->set_charset("utf8"); // đảm bảo hiển thị tiếng Việt

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    // Thiết lập mã hóa tiếng Việt
    $conn->set_charset("utf8");
   
}
?>
