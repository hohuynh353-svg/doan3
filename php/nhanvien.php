<?php
session_start();
require 'connect.php';

// Lấy giá trị từ form GET
$search = $_GET['search'] ?? '';
$trangthai = $_GET['trangthai'] ?? 'all';
$thoigian = $_GET['thoigian'] ?? 'all';

// Hàm đếm số lượng đơn theo trạng thái
function demDonHang($conn, $trangthai) {
    $count = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM donhang WHERE trangthai = ?");
    $stmt->bind_param("s", $trangthai);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}

$cho_xac_nhan = demDonHang($conn, 'Đang chờ xác nhận');
$da_xac_nhan  = demDonHang($conn, 'Đã xác nhận');
$dang_giao    = demDonHang($conn, 'Đang giao hàng');
$thanh_cong   = demDonHang($conn, 'Giao hàng thành công');
$da_huy       = demDonHang($conn, 'Đã hủy');

// Bắt đầu truy vấn
$sql = "
    SELECT d.*, u.hoten 
    FROM donhang d
    JOIN users u ON d.user_id = u.id
    WHERE 1=1
";

// Lọc theo từ khóa (ngày hoặc tên)
if (!empty($search)) {
    $keyword = trim($search);

    // Nếu nhập định dạng dd/mm/yyyy hoặc dd-mm-yyyy thì chuyển về yyyy-mm-dd
    if (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/', $keyword)) {
        $parts = preg_split('/[\/\-]/', $keyword);
        $day = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        $month = str_pad($parts[1], 2, '0', STR_PAD_LEFT);
        $year = $parts[2];
        $keyword = "$year-$month-$day";
    }

    $keyword = mysqli_real_escape_string($conn, $keyword);

    // Nếu là định dạng ngày thì tìm theo ngày
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $keyword)) {
        $sql .= " AND DATE(d.thoigian) = '$keyword'";
    } else {
        // Tìm theo họ tên (có dấu, không phân biệt chữ hoa/thường)
        $sql .= " AND u.hoten COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'";
    }
}

// Lọc theo trạng thái
if ($trangthai !== 'all') {
    $trangthai = mysqli_real_escape_string($conn, $trangthai);
    $sql .= " AND d.trangthai = '$trangthai'";
}

// Lọc theo thời gian
if ($thoigian !== 'all') {
    $today = date('Y-m-d');
    if ($thoigian === 'today') {
        $sql .= " AND DATE(d.thoigian) = '$today'";
    } elseif ($thoigian === 'week') {
        $sql .= " AND YEARWEEK(d.thoigian, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($thoigian === 'month') {
        $sql .= " AND MONTH(d.thoigian) = MONTH(CURDATE()) AND YEAR(d.thoigian) = YEAR(CURDATE())";
    }
}

$sql .= " ORDER BY d.thoigian DESC";

// Debug: kiểm tra truy vấn
// echo "<pre>$sql</pre>";

$result = mysqli_query($conn, $sql);
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý Đơn hàng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="../css/nhanvien.css">
  
</head>
<body>
  


<!-- HEADER -->
<div class="header-box">
  <div class="header-title centered">
    <i class="fas fa-shopping-cart"></i>
    <h1>Quản lí đơn hàng</h1>
  </div>

  <div class="staff-info-box">
    <div class="staff-avatar">
      <?= strtoupper(substr($_SESSION['nhanvien_taikhoan'], 0, 1)) . 
           strtoupper(substr(strrchr($_SESSION['nhanvien_taikhoan'], " "), 1, 1)) ?>
    </div>
    <div class="staff-detail">
      <div class="staff-name"><?= htmlspecialchars($_SESSION['nhanvien_taikhoan']) ?></div>
      <div class="staff-role">Nhân viên bán hàng</div>
    </div>
  </div>
</div>


<!-- NAVBAR -->
<div class="navbar">
  
  <a href="hoso.php"><i class="fas fa-user"></i> Hồ sơ</a>
  <a href="doimatkhau.php"><i class="fas fa-lock"></i> Đổi mật khẩu</a>
</div>



<div class="content-box"> 
<div id="thongke-container">
  <?php include 'thongke_donhang.php'; ?>
</div>

<!-- Form lọc -->
<form method="GET" class="filter-form" id="search-form">
   <div class="filter-left">
    <div class="input-group">
      <span class="search-icon" onclick="document.getElementById('search-form').submit()">🔍</span>
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm kiếm ....">
    </div>
  </div>


  <div class="filter-right">
   <select name="trangthai">
  <option value="all" <?= ($trangthai == 'all') ? 'selected' : '' ?>>Tất cả trạng thái</option>
  <option value="Đang chờ xác nhận" <?= ($trangthai == 'Đang chờ xác nhận') ? 'selected' : '' ?>>Đang chờ xác nhận</option>
  <option value="Đã xác nhận" <?= ($trangthai == 'Đã xác nhận') ? 'selected' : '' ?>>Đã xác nhận</option>
  <option value="Đang giao hàng" <?= ($trangthai == 'Đang giao hàng') ? 'selected' : '' ?>>Đang giao hàng</option>
  <option value="Giao hàng thành công" <?= ($trangthai == 'Giao hàng thành công') ? 'selected' : '' ?>>Giao hàng thành công</option>
  <option value="Đã hủy" <?= ($trangthai == 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
</select>


    <select name="thoigian">
      <option value="all" <?= ($thoigian == 'all') ? 'selected' : '' ?>>Tất cả thời gian</option>
      <option value="today" <?= ($thoigian == 'today') ? 'selected' : '' ?>>Hôm nay</option>
      <option value="week" <?= ($thoigian == 'week') ? 'selected' : '' ?>>Tuần này</option>
      <option value="month" <?= ($thoigian == 'month') ? 'selected' : '' ?>>Tháng này</option>
    </select>

    <button type="submit" class="filter-btn">🔽 Lọc</button>
  </div>
</form>



<!-- Modal Chi tiết đơn hàng -->
<div id="orderDetailModal" class="modal hidden">
  <div class="modal-content">
    <span class="close-btn" onclick="closeOrderModal()">&times;</span>
    <h2>Chi tiết đơn hàng</h2>
    <div id="order-detail-content">
      <!-- Nội dung sẽ được đổ từ JS -->
    </div>
  </div>
</div>


</div>
<?php
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>Không tìm thấy đơn hàng nào phù hợp.</p>";
} else {
    echo "<table><thead><tr>
            <th>Mã Đơn</th><th>Khách Hàng (ID)</th><th>Ngày Đặt</th><th>Tổng Tiền</th><th>Trạng Thái</th><th>Thao Tác</th>
          </tr></thead><tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
    $tt = $row['trangthai'];
   $badgeClass = ($tt == 'Đang chờ xác nhận') ? 'yellow' :
              (($tt == 'Giao hàng thành công') ? 'green' :
              (($tt == 'Đã hủy') ? 'red' : ''));


    $disable = function ($option, $current) {
        $order = [
            'Đang chờ xác nhận' => 1,
            'Đã xác nhận' => 2,
            'Đang giao hàng' => 3,
            'Giao hàng thành công' => 4,
            'Đã hủy' => 5
        ];
        if (!isset($order[$option]) || !isset($order[$current])) return '';
        return $order[$option] < $order[$current] ? 'disabled' : '';
    };

    $disabledAll = ($tt === 'Giao hàng thành công' || $tt === 'Đã hủy') ? 'disabled' : '';

    echo "<tr>
        <td>#{$row['id']}</td>
        <td>{$row['hoten']}</td>
        <td>{$row['thoigian']}</td>
        <td>{$row['tongtien']} VNĐ</td>
        <td>
            <select class='trangthai badge $badgeClass' onchange=\"updateTrangThai({$row['id']}, this.value)\" $disabledAll>";

    $options = ['Đang chờ xác nhận', 'Đã xác nhận', 'Đang giao hàng', 'Giao hàng thành công', 'Đã hủy'];
    foreach ($options as $option) {
        $selected = ($tt === $option) ? 'selected' : '';
        $disableOption = $disable($option, $tt);
        echo "<option value=\"$option\" $selected $disableOption>$option</option>";
    }

    echo "</select>
        </td>
        <td><button onclick='viewOrder({$row["id"]})' class='btn-view'>Xem</button></td>
    </tr>";
}

    echo "</tbody></table>";
}
?>

<script>
function updateTrangThai(id, trangthai) {
  fetch("capnhat_trangthai.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${id}&trangthai=${encodeURIComponent(trangthai)}`
  })
  .then(res => res.text())
  .then(data => {
    if (data.trim() === "OK") {
      capNhatThongKe();
    } else {
      alert("Lỗi: " + data);
    }
  });
}

function capNhatThongKe() {
  fetch("thongke_donhang.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("thongke-container").innerHTML = html;
    });
}
</script>
<script>
  function viewOrder(orderId) {
  const modal = document.getElementById("orderDetailModal");
  const content = document.getElementById("order-detail-content");
  content.innerHTML = "<p>Đang tải dữ liệu...</p>";
  modal.classList.remove("hidden");

  fetch("get_order_detail.php?id=" + orderId)
    .then(res => res.text())
    .then(html => {
      content.innerHTML = html;
    })
    .catch(err => {
      content.innerHTML = "<p>Lỗi tải dữ liệu chi tiết.</p>";
      console.error(err);
    });
}

function closeOrderModal() {
  document.getElementById("orderDetailModal").classList.add("hidden");
}

</script>

</body>
</html>
