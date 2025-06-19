<?php
require_once 'connect.php'; // kết nối tới database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Câu lệnh xóa
    $sql = "DELETE FROM nhanvien WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Xóa thành công, quay về trang danh sách
        header("Location: admin.php?msg=deleted");
    } else {
        echo "Lỗi khi xóa: " . mysqli_error($conn);
    }
} else {
    echo "Thiếu ID cần xóa.";
}
?>
