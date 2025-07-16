<?php
$tensp = $_POST['tensp'] ?? 'Tên sản phẩm';
$gia = $_POST['gia'] ?? 0;
$ghichu = $_POST['ghichu'] ?? 'Không có ghi chú';
$soluong = $_POST['soluong'] ?? 1;

$tong = $gia * $soluong;
?>

<div class="order-summary">
  <h2>Đơn hàng của bạn</h2>
  <div class="product">
    <img src="duongdan_anh.jpg" alt="<?= htmlspecialchars($tensp) ?>" />
    <div class="product-info">
      <p><strong><?= htmlspecialchars($tensp) ?></strong></p>
      <p>Số lượng: <?= (int)$soluong ?></p>
      <p>Ghi chú: <?= htmlspecialchars($ghichu) ?></p>
      <p>Đơn giá: <strong><?= number_format($gia, 0, ',', '.') ?>đ</strong></p>
    </div>
  </div>
  <div class="total">
    <p><strong>Tổng cộng: <?= number_format($tong, 0, ',', '.') ?>đ</strong></p>
    <button class="btn-confirm">Xác nhận đặt hàng</button>
  </div>
</div>
