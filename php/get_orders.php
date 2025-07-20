<?php
// get_orders.php

header('Content-Type: application/json');
include 'connect.php'; // Kết nối CSDL

// Truy vấn dữ liệu đơn hàng và lấy họ tên khách hàng
$sql = "
    SELECT 
        donhang.id,
        users.hoten,
        donhang.thoigian,
        donhang.tongtien,
        donhang.trangthai
    FROM donhang
    JOIN users ON donhang.user_id = users.id
    ORDER BY donhang.id DESC
";

$result = mysqli_query($conn, $sql);

// Mảng kết quả
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Trả về dữ liệu dạng JSON
echo json_encode($orders);
?>
