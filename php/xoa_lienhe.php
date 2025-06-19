<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM lienhe WHERE id = $id";

    if ($conn->query($sql)) {
        // Xóa thành công, quay lại trang quản trị liên hệ
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi khi xóa: " . $conn->error;
    }
} else {
    echo "Không có ID hợp lệ.";
}
?>
