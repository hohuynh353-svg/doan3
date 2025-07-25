<?php
session_start();
$donhang = $_SESSION['donhang'] ?? [];
$tong = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác nhận đặt hàng</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      margin: 0;
      padding: 40px;
      background-color: #f7f7f7;
    }

    .container {
      display: flex;
      max-width: 1200px;
      margin: auto;
      gap: 30px;
    }

    .form-left,
    .order-right {
      background-color: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      flex: 1;
    }

    h2 {
      color: #007bff;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }

    .submit-btn {
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

    .order-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
    }

    .order-image-wrapper {
      position: relative;
      margin-right: 15px;
    }

    .order-image-wrapper img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
    }

    .quantity-badge {
      position: absolute;
      top: -10px;
      left: -10px;
      background-color: red;
      color: white;
      font-size: 13px;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      text-align: center;
      line-height: 24px;
    }

    .order-content {
      flex: 1;
    }

    .order-title {
      font-weight: bold;
      margin: 0;
    }

    .order-note {
      font-size: 14px;
      color: #555;
      margin-top: 4px;
    }

    .order-price {
      font-weight: bold;
      color: #333;
      white-space: nowrap;
      margin-left: 10px;
    }

    .total {
      text-align: right;
      font-weight: bold;
      font-size: 18px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Bên trái: Form -->
  <div class="form-left">
   
      <h2>📋 Nhập thông tin nhận hàng</h2>
<form action="xulydathang.php" method="post">
  <label>Họ tên:</label>
  <input type="text" name="hoten" required><br><br>

  <label>Số điện thoại:</label>
  <input type="text" name="sdt" required><br><br>
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
      <input type="text" id="thanhpho" name="thanhpho" value="Cần Thơ">

      <br><br>
      <button class="submit-btn" type="submit">✅ XÁC NHẬN ĐẶT HÀNG</button>
    </form>
  </div>

  <!-- Bên phải: Đơn hàng -->
  <div class="order-right">
    <h2>🛒 Đơn hàng (<?= array_sum(array_column($donhang, 'soluong')) ?> sản phẩm)</h2>

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
