<?php
include 'connect.php';

function demTrangThai($conn, $tt) {
  $sql = "SELECT COUNT(*) as tong FROM donhang WHERE trangthai = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $tt);
  $stmt->execute();
  $tong = 0;
  $stmt->bind_result($tong);
  $stmt->fetch();
  return $tong;
}

$cho_xac_nhan = demTrangThai($conn, "Đang chờ xác nhận");
$da_xac_nhan = demTrangThai($conn, "Đã xác nhận");
$dang_giao = demTrangThai($conn, "Đang giao hàng");
$thanh_cong = demTrangThai($conn, "Giao hàng thành công");
$da_huy = demTrangThai($conn, "Đã huỷ");

?>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
  <div onclick="filterByStatus('Đang chờ xác nhận')" style="flex: 1; background: #fff3cd; color: #856404; padding: 20px; border-radius: 15px; text-align: center; cursor: pointer;">
    <h2><?= $cho_xac_nhan ?></h2><p>Đang chờ xác nhận</p>
  </div>
  <div onclick="filterByStatus('Đã xác nhận')" style="flex: 1; background: #cce5ff; color: #004085; padding: 20px; border-radius: 15px; text-align: center; cursor: pointer;">
    <h2><?= $da_xac_nhan ?></h2><p>Đã xác nhận</p>
  </div>
  <div onclick="filterByStatus('Đang giao hàng')" style="flex: 1; background: #f8f8bfff; color: #070707ff; padding: 20px; border-radius: 15px; text-align: center; cursor: pointer;">
    <h2><?= $dang_giao ?></h2><p>Đang giao hàng</p>
  </div>
  <div onclick="filterByStatus('Giao hàng thành công')" style="flex: 1; background: #29d98aff; color: #0b0c0dff; padding: 20px; border-radius: 15px; text-align: center; cursor: pointer;">
    <h2><?= $thanh_cong ?></h2><p>Giao hàng thành công</p>
  </div>
  <div onclick="filterByStatus('Đã huỷ')" style="flex: 1; background: #f2606cff; color: #080707ff; padding: 20px; border-radius: 15px; text-align: center; cursor: pointer;">
    <h2><?= $da_huy ?></h2><p>Đã huỷ</p>
  </div>
</div>

<script>
function filterByStatus(status) {
  const rows = document.querySelectorAll("#order-table tbody tr");

  rows.forEach((row) => {
    const trangThai = row.querySelector(".trangthai").textContent.trim();

    if (trangThai === status || status === 'Tất cả') {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
</script>
