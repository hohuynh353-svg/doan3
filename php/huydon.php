<?php
// Kết nối CSDL
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donhang_id'])) {
    $id = intval($_POST['donhang_id']);

    // Ví dụ cập nhật trạng thái đơn hàng thành "Đã hủy"
    $sql = "UPDATE donhang SET trangthai = 'Đã hủy' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Đơn hàng đã được hủy thành công.";
    } else {
        echo "Lỗi khi hủy đơn hàng: " . mysqli_error($conn);
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
    