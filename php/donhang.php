<?php
session_start();
$donhang = $_SESSION['donhang'] ?? [];
$tong = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đơn hàng của bạn</title>
<style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      padding: 30px;
      max-width: 900px;
      margin: auto;
      color: #333;
    }
    h2 {
      margin-bottom: 25px;
      color: #2c3e50;
    }
    .order-item {
      display: flex;
      margin-bottom: 20px;
      padding: 15px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      align-items: center;
    }
    .order-item img {
      width: 70px;
      height: 70px;
      margin-right: 15px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #ddd;
    }
    .order-item div {
      flex: 1;
    }
    .order-item p {
      margin: 3px 0;
    }
    .total {
      font-weight: bold;
      font-size: 20px;
      margin-top: 25px;
      text-align: right;
      color: #007bff;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      transition: background 0.3s ease;
    }
    .btn-confirm {
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
    .btn-confirm:hover {
      background-color: #0056b3;
    }
    .btn-add {
      background-color: #28a745;
      color: white;
    }
    .btn-add:hover {
      background-color: #1e7e34;
    }
    .btn-delete {
      color: #dc3545;
      text-decoration: none;
      font-size: 14px;
      display: inline-block;
      margin-top: 8px;
      transition: color 0.3s ease;
    }
    .btn-delete:hover {
      color: #a71d2a;
    }
    .order-price {
  font-size: 14px;
  color: red;
  margin: 3px 0;
}

.order-qty {
  font-weight: bold;
  font-size: 14px;
  margin: 3px 0;
}

.order-note {
  font-size: 14px;
  color: #000;
  margin: 3px 0;
}

.order-total {
  color: #007bff;
  font-weight: bold;
  font-size: 16px;
  margin: 6px 0;
}
form {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  margin-top: 20px;
  border: 1px solid #e0e0e0;
}

form .order-item {
  border: 1px solid #eee;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
  background-color: #fafafa;
}

form .order-item:hover {
  background-color: #f0f8ff;
  transition: background 0.3s ease;
}

form .total {
  background-color: #f6f9fc;
  padding: 10px;
  border-radius: 6px;
  border: 1px dashed #007bff;
  margin-top: 30px;
}


  </style>
</head>
<body>

<h2>Đơn hàng của bạn  (<?= array_sum(array_column($donhang, 'soluong')) ?> sản phẩm)</h2>

<?php if (empty($donhang)): ?>
  <p>🛒 Chưa có món nào trong đơn hàng.</p>
  <a href="index.php" class="btn btn-add">⬅ Quay lại chọn món</a>
<?php else: ?>
 <form method="post" action="xacnhan.php">
  <?php foreach ($donhang as $index => $mon): 
    $thanhtien = $mon['gia'] * $mon['soluong'];
    $tong += $thanhtien;
  ?>
    <div class="order-item">
      <img src="<?= htmlspecialchars($mon['hinhanh']) ?>" 
           onerror="this.src='../img/no-image.png'" 
           alt="Ảnh món">
      <div class="order-details">
        <p><strong><?= htmlspecialchars($mon['tenmon']) ?></strong></p>
        <p class="order-price">Giá: <?= number_format($mon['gia'], 0, ',', '.') ?>đ</p>
        <p class="order-qty">Số lượng: <?= $mon['soluong'] ?></p>
        <?php if (!empty($mon['ghichu'])): ?>
          <p class="order-note">Ghi chú: <?= htmlspecialchars($mon['ghichu']) ?></p>
        <?php endif; ?>
        <p class="order-total">Thành tiền: <?= number_format($thanhtien, 0, ',', '.') ?>đ</p>
        <a href="remove_item.php?index=<?= $index ?>" 
           onclick="return confirm('Xóa món này khỏi đơn?')" 
           class="btn-delete">🗑️ Xóa</a>
      </div>
    </div>
  <?php endforeach; ?>

  <p class="total">🧾 Tổng cộng: <?= number_format($tong, 0, ',', '.') ?>đ</p>

  <button type="submit" class="btn btn-confirm">✅ ĐẶT HÀNG</button>
  <a href="index.php" class="btn btn-add">➕ Thêm món khác</a>
</form>

<?php endif; ?>

</body>
</html>
