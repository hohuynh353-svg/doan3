<?php
include 'connect.php'; // hoặc đường dẫn file kết nối CSDL của bạn

$status = $_GET['status'];
$sql = "SELECT donhang.id, user.hoten, donhang.thoigian, donhang.trangthai 
        FROM donhang 
        JOIN user ON donhang.user_id = user.id 
        WHERE donhang.trangthai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();

echo "<h3>Danh sách đơn hàng: $status</h3>";
echo "<table border='1' cellpadding='10'>
<tr>
  <th>ID</th>
  <th>Tên khách</th>
  <th>Ngày đặt</th>
  <th>Trạng thái</th>
</tr>";

while ($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['hoten']}</td>
    <td>{$row['thoigian']}</td>
    <td>{$row['trangthai']}</td>
  </tr>";
}

echo "</table>";
?>
