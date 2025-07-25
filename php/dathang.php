<?php
session_start();

$tenmon = $_POST['tenmon'] ?? '';
$gia = (int) ($_POST['gia'] ?? 0);
$soluong = (int) ($_POST['soluong'] ?? 1);
$ghichu = $_POST['ghichu'] ?? '';
$hinhanh = $_POST['hinhanh'] ?? '../img/no-image.png';

if (!isset($_SESSION['donhang'])) {
    $_SESSION['donhang'] = [];
}

$daCo = false;
foreach ($_SESSION['donhang'] as &$mon) {
    if ($mon['tenmon'] === $tenmon && $mon['gia'] == $gia) {
        $mon['soluong'] += $soluong;
        $daCo = true;
        break;
    }
}
unset($mon);

if (!$daCo) {
    $_SESSION['donhang'][] = [
        'tenmon' => $tenmon,
        'gia' => $gia,
        'soluong' => $soluong,
        'ghichu' => $ghichu,
        'hinhanh' => $hinhanh
    ];
}

header("Location: donhang.php");
exit;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt hàng - EGA Food</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* CSS giữ nguyên như bạn gửi */
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f7f7f7; }
    .container { display: flex; max-width: 1200px; margin: 30px auto; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .form-section, .order-summary { padding: 30px; }
    .form-section { flex: 2; border-right: 1px solid #ddd; }
    .order-summary { flex: 1; }
    h2 { margin-bottom: 20px; }
    input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
    .payment-option { margin: 10px 0; }
    .order-summary img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin-right: 10px; }
    .order-item { display: flex; align-items: center; margin-bottom: 15px; }
    .total { font-size: 20px; font-weight: bold; color: #007bff; }
    button { padding: 12px 20px; background-color: #2b7cd3; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 15px; }
    button:hover { background-color: #1a64b2; }
    .discount-code { display: flex; margin: 15px 0; }
    .discount-code input { flex: 1; margin-right: 10px; }
    .back-link { margin-top: 15px; display: inline-block; color: #007bff; text-decoration: none; }
  </style>
</head>
<body>

<form method="POST" action="process_order.php">
  <div class="container">
    <!-- Thông tin khách hàng -->
    <div class="form-section">
      <h2>Thông tin nhận hàng</h2>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="fullname" placeholder="Họ và tên" required>
      <input type="text" name="phone" placeholder="Số điện thoại (tùy chọn)">
      <input type="text" name="address" placeholder="Địa chỉ (tùy chọn)">
      <select name="province">
        <option value="">Tỉnh thành</option>
        <option value="HCM">Hồ Chí Minh</option>
        <option value="HN">Hà Nội</option>
      </select>
      <select name="district">
        <option value="">Quận huyện (tùy chọn)</option>
      </select>
      <select name="ward">
        <option value="">Phường xã (tùy chọn)</option>
      </select>
      <textarea name="note" placeholder="Ghi chú (tùy chọn)"></textarea>

      <h2>Thanh toán</h2>
      <div class="payment-option">
        <input type="radio" name="payment" value="bank" required> Chuyển khoản
      </div>
      <div class="payment-option">
        <input type="radio" name="payment" value="cod"> Thu hộ (COD)
      </div>
    </div>

    <!-- Hiển thị đơn hàng -->
    <div class="order-summary">
      <h2>Đơn hàng (<?= count($donhang) ?> sản phẩm)</h2>

      <?php foreach ($donhang as $item): 
          $tong = $item['gia'] * $item['soluong'];
          $tongcong += $tong;
      ?>
      <div class="order-item">
        <img src="<?= htmlspecialchars($item['hinhanh']) ?>" alt="Ảnh món ăn">
        <div>
          <strong><?= htmlspecialchars($item['tenmon']) ?></strong><br>
          Giá: <?= number_format($item['gia'], 0, ',', '.') ?>đ<br>
          Số lượng: <?= $item['soluong'] ?><br>
          Ghi chú: <?= htmlspecialchars($item['ghichu']) ?>
        </div>
      </div>
      <?php endforeach; ?>

      <p><strong>Tạm tính:</strong> <?= number_format($tongcong, 0, ',', '.') ?>đ</p>
      <p class="total"><strong>Tổng cộng:</strong> <?= number_format($tongcong, 0, ',', '.') ?>đ</p>

      <a href="index.php" class="back-link">➕ Thêm món khác</a>
      <button type="submit">ĐẶT HÀNG</button>
    </div>
  </div>
</form>

</body>
</html>
