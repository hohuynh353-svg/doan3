<?php
session_start();
$donhang = $_SESSION['donhang'] ?? [];
$tong = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác nhận đơn hàng</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      padding: 30px;
    }
    .container {
      display: flex;
      gap: 30px;
      max-width: 1200px;
      margin: auto;
    }
    .form-left, .order-right {
      background: white;
      padding: 20px;
      border-radius: 10px;
      flex: 1;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-left h2, .order-right h2 {
      margin-top: 0;
      color: #007bff;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
      margin-top: 10px;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }
    .order-item {
      display: flex;
      margin-bottom: 15px;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
      position: relative;
    }
    .order-image-wrapper {
      position: relative;
      width: 60px;
      height: 60px;
      margin-right: 12px;
    }
    .order-image-wrapper img {
      width: 60px;
      height: 60px;
      border-radius: 6px;
      object-fit: cover;
    }
    .quantity-badge {
      position: absolute;
      top: -5px;
      left: -5px;
      background-color: #007bff;
      color: white;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      font-size: 13px;
      text-align: center;
      line-height: 22px;
      font-weight: bold;
    }
    .order-content {
      flex: 1;
    }
    .order-title {
      font-weight: bold;
      margin: 0;
    }
    .order-note {
      font-size: 13px;
      color: #777;
    }
    .order-price {
      font-weight: bold;
      text-align: right;
      white-space: nowrap;
    }
    .total {
      text-align: right;
      font-size: 18px;
      font-weight: bold;
      margin-top: 20px;
    }
    .btn-submit {
      width: 100%;
      padding: 12px;
      background: #007bff;
      color: white;
      border: none;
      font-weight: bold;
      border-radius: 6px;
      margin-top: 20px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Địa chỉ nhận hàng -->
  <div class="form-left">
    <h2>📍 Nhập địa chỉ giao hàng</h2>
    <form action="xemdonhang.php" method="post">
      <label for="sonha">Số nhà:</label>
      <input type="text" id="sonha" name="sonha" required>

      <label for="duong">Đường:</label>
      <select id="duong" name="duong" required>
        <option value="">-- Chọn đường --</option>
        <option value="30 Tháng 4">30 Tháng 4</option>
        <option value="Nguyễn Văn Cừ">Nguyễn Văn Cừ</option>
        <option value="Lý Tự Trọng">Lý Tự Trọng</option>
        <option value="Trần Hưng Đạo">Trần Hưng Đạo</option>
        <option value="Mậu Thân">Mậu Thân</option>
      </select>

      <label for="phuong">Phường:</label>
      <select id="phuong" name="phuong" required>
        <option value="">-- Chọn phường --</option>
        <option value="Hưng Lợi">Hưng Lợi</option>
        <option value="An Khánh">An Khánh</option>
        <option value="Tân An">Tân An</option>
        <option value="Xuân Khánh">Xuân Khánh</option>
        <option value="An Cư">An Cư</option>
      </select>

      <label for="quan">Quận:</label>
      <select id="quan" name="quan" required>
        <option value="">-- Chọn quận --</option>
        <option value="Ninh Kiều">Ninh Kiều</option>
        <option value="Cái Răng">Cái Răng</option>
        <option value="Bình Thủy">Bình Thủy</option>
        <option value="Ô Môn">Ô Môn</option>
        <option value="Thốt Nốt">Thốt Nốt</option>
      </select>

      <label for="thanhpho">Thành phố:</label>
      <select id="thanhpho" name="thanhpho" required>
        <option value="Cần Thơ">Cần Thơ</option>
      </select>

      <button type="submit" class="btn-submit">✅ XÁC NHẬN ĐẶT HÀNG</button>
    </form>
  </div>

  <!-- Đơn hàng bên phải -->
  <div class="order-right">
    <h2>Đơn hàng (<?= array_sum(array_column($donhang, 'soluong')) ?> sản phẩm)</h2>

    <?php if (empty($donhang)): ?>
      <p>Chưa có món nào trong giỏ hàng.</p>
    <?php else: ?>
      <?php foreach ($donhang as $mon): 
        $thanhtien = $mon['gia'] * $mon['soluong'];
        $tong += $thanhtien;
      ?>
        <div class="order-item">
          <div class="order-image-wrapper">
            <span class="quantity-badge"><?= $mon['soluong'] ?></span>
            <img src="<?= htmlspecialchars($mon['hinhanh']) ?>" onerror="this.src='../img/no-image.png'">
          </div>
          <div class="order-content">
            <p class="order-title"><?= htmlspecialchars($mon['tenmon']) ?></p>
            <p class="order-note">Ghi chú: <?= htmlspecialchars($mon['ghichu']) ?: 'Không có' ?></p>
          </div>
          <div class="order-price"><?= number_format($thanhtien, 0, ',', '.') ?>đ</div>
        </div>
      <?php endforeach; ?>

      <p class="total">Tổng cộng: <?= number_format($tong, 0, ',', '.') ?>đ</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
