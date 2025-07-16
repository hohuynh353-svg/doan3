<?php
require_once 'connect.php';

// Xử lý cập nhật trạng thái nếu có gửi form
if (isset($_POST['trangthai'])) {
    $trangthai = $_POST['trangthai'];
    $conn->query("UPDATE hethong SET trangthai = '$trangthai' LIMIT 1");
}

// Lấy trạng thái hiện tại
$result = $conn->query("SELECT trangthai FROM hethong LIMIT 1");
$row = $result->fetch_assoc();
$trangthai = $row['trangthai'];
?>

<h2>🛠 Quản lý trạng thái quán</h2>
<form method="post">
  <p>Trạng thái hiện tại: <strong><?= $trangthai === 'mo' ? '🟢 Đang mở' : '🔴 Đang đóng' ?></strong></p>
  <button name="trangthai" value="mo">🟢 MỞ CỬA</button>
  <button name="trangthai" value="dong">🔴 ĐÓNG CỬA</button>
</form>
