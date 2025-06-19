<?php
include 'connect.php'; 
date_default_timezone_set('Asia/Ho_Chi_Minh'); // ✅ Set múi giờ về Việt Nam

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $noidung = $_POST['noidung'];
    $ngaylienhe = date('Y-m-d H:i:s');

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO lienhe (hoten, email, sdt, noidung, ngaylienhe) 
            VALUES (?, ?, ?, ?, ?)";

    // Sử dụng prepared statement để tránh lỗi SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $hoten, $email, $sdt, $noidung, $ngaylienhe);

    // Thực thi và kiểm tra
    if ($stmt->execute()) {
        echo "<script>alert('Gửi thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
