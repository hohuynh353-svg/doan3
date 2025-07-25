<?php
session_start();
$thongtin = $_SESSION['thongtin_donhang'] ?? null;

if (!$thongtin) {
    echo "Không có dữ liệu đơn hàng.";
    exit();
}
?>


<div class="order-container">

<h2>🎉 Đặt hàng thành công!</h2>
<p><strong>👤 Họ tên:</strong> <?= htmlspecialchars($thongtin['hoten']) ?></p>
<p><strong>📞 Số điện thoại:</strong> <?= htmlspecialchars($thongtin['sdt']) ?></p>
<p><strong>📍 Địa chỉ:</strong> <?= htmlspecialchars($thongtin['diachi']) ?></p>

<h3 style="color:#007bff;"><span style="font-size: 18px;">🍽️</span> Chi Tiết Món Ăn</h3>

<table class="order-table">
  <thead>
    <tr>
      <th>Món ăn</th>
      <th>Số lượng</th>
      <th>Giá</th>
      <th>Thành tiền</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($thongtin['danhsach_mon'] as $mon): 
        $thanhtien = $mon['soluong'] * $mon['gia'];
    ?>
    <tr>
      <td><?= htmlspecialchars($mon['tenmon']) ?></td>
      <td><?= $mon['soluong'] ?></td>
      <td><?= number_format($mon['gia']) ?>đ</td>
      <td><?= number_format($thanhtien) ?>đ</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<a href="index.php">← Quay lại trang chính</a>
</div>
<style>
  .order-container {
  max-width: 600px;
  margin: 0 auto;
  background-color: #ffffff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.order-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 15px;
  background-color: #fff;
}

.order-table th, .order-table td {
  border: 1px solid #ccc;
  padding: 10px 12px;
  text-align: center;
}

.order-table th {
  background-color: #f1f8ff;
  color: #000;
  font-weight: bold;
}

.order-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.order-table tr:hover {
  background-color: #eef6ff;
}
body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f7f9fc;
  color: #333;
  margin: 0;
  padding: 30px;
}

h2 {
  color: #28a745;
  font-size: 24px;
  margin-bottom: 10px;
}

h3 {
  color: #007bff;
  margin-top: 20px;
}

p {
  margin: 6px 0;
  font-size: 16px;
}

strong {
  color: #444;
}

ul {
  background-color: #fff;
  border: 1px solid #ddd;
  padding: 15px 20px;
  border-radius: 8px;
  list-style-type: disc;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

li {
  padding: 4px 0;
  font-size: 15px;
}

a {
  display: inline-block;
  margin-top: 20px;
  text-decoration: none;
  color: #fff;
  background-color: #6c63ff;
  padding: 10px 20px;
  border-radius: 6px;
  transition: background-color 0.3s;
}

a:hover {
  background-color: #5548e2;
}
</style>
