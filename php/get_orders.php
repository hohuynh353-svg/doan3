<?php
// get_orders.php

header('Content-Type: application/json');
include 'connect.php'; // File này là nơi bạn kết nối MySQL (xem phần dưới nếu chưa có)

// Truy vấn dữ liệu đơn hàng
$sql = "SELECT * FROM donhang ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Mảng kết quả
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Trả về dạng JSON
echo json_encode($orders);
?>
