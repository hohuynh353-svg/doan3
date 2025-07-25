<?php
require 'connect.php';

$id = intval($_GET['id'] ?? 0);

// Lấy đơn hàng vãng lai
$sql = "SELECT * FROM donhang WHERE id = $id AND user_id IS NULL";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "<p style='color:red'>Không tìm thấy đơn hàng (hoặc không phải của khách vãng lai).</p>";
    exit;
}

// Gộp địa chỉ
$diachi_parts = [$order['sonha'], $order['duong'], $order['phuong'], $order['quan'], $order['thanhpho']];
$diachi = implode(', ', array_filter($diachi_parts));

// Lấy chi tiết món ăn
$ct_sql = "SELECT * FROM chitiet_donhang WHERE id_donhang = $id";
$ct_result = mysqli_query($conn, $ct_sql);
if (!$ct_result) {
    die("Lỗi truy vấn chi tiết đơn hàng: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?= $id ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background: #fdfdfd;
      color: #333;
    }
    .section-title {
      font-size: 20px;
      font-weight: bold;
      color: #2c3e50;
      margin-top: 25px;
      margin-bottom: 10px;
      border-left: 5px solid #28a745;
      padding-left: 10px;
    }
    .info-box {
      background: #f9f9f9;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 20px;
    }
    .info-box p {
      margin: 5px 0;
    }
    .order-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .order-table th, .order-table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }
    .order-table th {
      background-color: #e0f0e9;
    }
    .notice {
      margin-top: 20px;
      padding: 12px;
      background: #e8f5e9;
      border-left: 5px solid #28a745;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <div class="section-title">📦 Thông Tin Đơn Hàng</div>
  <div class="info-box">
    <p><b>Mã đơn hàng:</b> #<?= $order['id'] ?></p>
    <p><b>Trạng thái:</b> <span style="color:green;font-weight:bold;"><?= $order['trangthai'] ?></span></p>
    <p><b>Thời gian đặt:</b> <?= $order['thoigian'] ?></p>
    <p><b>Ghi chú:</b> <?= $order['ghichu'] ?: 'Không có' ?></p>
    <p><b>Tổng tiền:</b> <span style="color:#c40000; font-weight:bold;"><?= number_format($order['tongtien'], 0, ".", ".") ?>đ</span></p>
  </div>

  <div class="section-title">👤 Thông Tin Khách Hàng</div>
  <div class="info-box">
    <p><b>Họ tên:</b> <?= $order['hoten'] ?></p>
    <p><b>SĐT:</b> <?= $order['sdt'] ?></p>
    <p><b>Địa chỉ:</b> <?= $diachi ?></p>
  </div>

  <div class="section-title">🍲 Danh Sách Món Ăn</div>
  <table class="order-table">
    <tr>
      <th>Món ăn</th>
      <th>Số lượng</th>
      <th>Giá</th>
      <th>Thành tiền</th>
    </tr>
    <?php if (mysqli_num_rows($ct_result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($ct_result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['tenmon']) ?></td>
          <td><?= $row['soluong'] ?></td>
          <td><?= number_format($row['gia'], 0, ".", ".") ?>đ</td>
          <td><?= number_format($row['thanhtien'], 0, ".", ".") ?>đ</td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4">Không có dữ liệu món ăn.</td></tr>
    <?php endif; ?>
  </table>

  <div class="notice">
    ✅ Đây là đơn hàng khách vãng lai, không tích điểm.<br>
    ❗ Nếu có thắc mắc, vui lòng liên hệ hotline hỗ trợ.
  </div>

</body>
</html>
