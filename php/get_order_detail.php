<?php
include 'connect.php';
$id = $_GET['id'] ?? 0;

// Lấy đơn hàng
$order_sql = "SELECT * FROM donhang WHERE id = $id";
$order_result = mysqli_query($conn, $order_sql);
$order = mysqli_fetch_assoc($order_result);

// Gộp địa chỉ
$diachi_parts = [$order['sonha'], $order['duong'], $order['phuong'], $order['quan'], $order['thanhpho']];
$diachi = implode(', ', array_filter($diachi_parts));

// Lấy thông tin người dùng từ bảng users
$user_id = $order['user_id'];
$user_sql = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

// Lấy chi tiết món ăn
$ct_sql = "SELECT * FROM chitiet_donhang WHERE id_donhang = $id";
$ct_result = mysqli_query($conn, $ct_sql);

// Xuất nội dung
echo '
<div style="text-align:right">
  <button onclick="document.getElementById(\'order-detail-modal\').classList.add(\'hidden\')"
    style="background:#dc3545;color:white;border:none;border-radius:4px;padding:6px 12px;cursor:pointer;">
    ✖ Đóng
  </button>
</div>
';

echo '


<div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
  <h4 style="text-align:center;"><i class="fas fa-user"></i> Thông Tin Khách Hàng</h4>
  <p><b>Họ tên:</b> ' . ($user['hoten'] ?? '(ẩn hoặc chưa có)') . '</p>
  <p><b>Email:</b> ' . ($user['email'] ?? '(ẩn hoặc chưa có)') . '</p>
  <p><b>Địa chỉ:</b> ' . $diachi . '</p>
 <p><b>Điểm tích lũy hiện tại:</b> <span style="color:red;font-weight:bold;">' . ($user['diemtichluy'] ?? 0) . ' điểm</span></p>

</div>

<div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
  <h4 style="text-align:center;"><i class="fas fa-box"></i> Thông Tin Đơn Hàng</h4>
  <p><b>Mã đơn hàng:</b> ' . $order['id'] . '</p>
  <p><b>Trạng thái:</b> <span style="color:green;font-weight:bold;">' . $order['trangthai'] . '</span></p>

  <p><b>Thời gian:</b> ' . $order['thoigian'] . '</p>
  <p><b>Ghi chú:</b> ' . $order['ghichu'] . '</p>
<p><b>Tổng tiền:</b> <span style="color:#c40000; font-weight:bold;">' . number_format($order['tongtien'], 0, ".", ".") . 'đ</span></p>

</div>

<h4 style="text-align:center;"><i class="fas fa-utensils"></i> Chi Tiết Món Ăn</h4>
<table border="1" cellpadding="8" cellspacing="0">
  <tr><th>Món ăn</th><th>Số lượng</th><th>Giá</th><th>Thành tiền</th></tr>
';

if ($ct_result && mysqli_num_rows($ct_result) > 0) {
  while ($row = mysqli_fetch_assoc($ct_result)) {
    echo '
    <tr>
      <td>' . $row['tenmon'] . '</td>
      <td>' . $row['soluong'] . '</td>
      <td>' . number_format($row['gia'], 0, ".", ".") . 'đ</td>
      <td>' . number_format($row['thanhtien'], 0, ".", ".") . 'đ</td>
    </tr>';
  }
} else {
  echo '<tr><td colspan="4" style="text-align:center;">Không có dữ liệu món ăn.</td></tr>';
}

echo '
</table>

<div style="margin-top:10px;padding:10px;background:#e0f5e5;border-left:5px solid green">
✅ Bạn đã được cộng điểm nếu không sử dụng ưu đãi.
<br>
❗ Nếu bạn đã dùng ưu đãi, điểm đã được trừ tương ứng và tổng tiền đã giảm.
</div>';
?>