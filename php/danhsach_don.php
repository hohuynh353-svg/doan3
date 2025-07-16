<?php
require 'connect.php';

// Lấy danh sách đơn hàng
$sql = "
SELECT d.id, u.hoten AS tenkhach, d.tongtien, d.thoigian, d.trangthai,
       COUNT(cd.id) AS soluongmon,
       GROUP_CONCAT(cd.tenmon SEPARATOR ', ') AS tenmon
FROM donhang d
JOIN users u ON d.user_id = u.id
JOIN chitiet_donhang cd ON d.id = cd.id_donhang
GROUP BY d.id
ORDER BY d.id DESC
";

// Thực hiện truy vấn
$result = $conn->query($sql);

// Kiểm tra và lấy dữ liệu
$donhangs = [];
if ($result && $result->num_rows > 0) {
    $donhangs = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Không có đơn hàng nào.";
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Danh sách đơn hàng</title>
  <style>
    body {
      font-family: Arial;
      padding: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th {
      background-color: #3498db;
      color: white;
      padding: 12px;
      text-align: center;
    }
    td {
      padding: 10px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    h2 {
      margin-bottom: 10px;
    }
    .btn {
      padding: 6px 12px;
      background-color: #2ecc71;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
    .btn:hover {
      background-color: #27ae60;
    }
  </style>
</head>
<body>

<h2>🧾 Danh Sách Đơn Hàng</h2>

<table>
  <tr>
    <th>Mã Đơn</th>
    <th>Khách Hàng</th>
    <th>Tên Món</th>
    <th>Số Lượng Món</th>
    <th>Ngày Đặt</th>
    <th>Tổng Tiền</th>
    <th>Trạng Thái</th>
    <th>Thao Tác</th>
  </tr>
  <?php foreach ($donhangs as $row): ?>
    <tr>
      <td>#<?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['tenkhach']) ?></td>
      <td><?= htmlspecialchars($row['tenmon']) ?></td>
      <td><?= $row['soluongmon'] ?></td>
      <td><?= date('d/m/Y H:i', strtotime($row['thoigian'])) ?></td>
      <td><?= number_format($row['tongtien'], 0, ',', '.') ?>đ</td>
      <td><?= htmlspecialchars($row['trangthai']) ?></td>
      <td><a href="xem_donhang.php?id=<?= $row['id'] ?>" class="btn">👁 Xem chi tiết</a></td>
    </tr>
  <?php endforeach; ?>
</table>

</body>
</html>
