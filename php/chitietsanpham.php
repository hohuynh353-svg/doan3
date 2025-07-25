<?php
require_once 'connect.php';

// Kiểm tra id
if (!isset($_GET['id'])) {
    echo "Không tìm thấy món ăn.";
    exit;
}

$id = intval($_GET['id']);

// Truy vấn món ăn và tên danh mục
$stmt = $conn->prepare("SELECT m.*, d.tendanhmuc 
                        FROM menu m
                        JOIN danhmucmon d ON m.danhmucmon = d.madanhmuc
                        WHERE m.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$mon = $result->fetch_assoc();

// Kiểm tra kết quả
if (!$mon) {
    echo "Món ăn không tồn tại!";
    exit;
}

// Đảm bảo biến tồn tại
$same_price_items = [];

// Giá hiện tại
$giaHienTai = $mon['gia'];
$giaMin = $giaHienTai - 10000;
$giaMax = $giaHienTai + 10000;

// Query lấy sản phẩm cùng giá
$sql = "SELECT * FROM menu 
        WHERE gia BETWEEN $giaMin AND $giaMax
          AND id != {$mon['id']}
        LIMIT 8";


$result = mysqli_query($conn, $sql);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $same_price_items[] = $row;
  }
}


// Lấy thông tin món
$tenmon = $mon['tenmon'];
$tendanhmuc = $mon['tendanhmuc'];
$danhmuc_id = $mon['danhmucmon'];

// Truy vấn các món liên quan cùng danh mục
$stmt2 = $conn->prepare("SELECT * FROM menu 
                         WHERE danhmucmon = ? AND id != ? 
                         ORDER BY RAND() LIMIT 4");
$stmt2->bind_param("ii", $danhmuc_id, $id);
$stmt2->execute();
$related_result = $stmt2->get_result();
$related_items = $related_result->fetch_all(MYSQLI_ASSOC);
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
  <a href="index.php">Trang chủ</a> /
  <a href="danhmuc.php?ten=<?php echo urlencode($tendanhmuc); ?>">
    <?php echo htmlspecialchars($tendanhmuc); ?>
  </a> /
  <span class="current"><?php echo htmlspecialchars($tenmon); ?></span>
</nav>

<!-- Hiển thị thông tin món ăn -->
<h1><?php echo htmlspecialchars($tenmon); ?></h1>




<!-- CSS breadcrumb -->
<style>
.breadcrumb {
  padding: 12px 20px;
  font-size: 14px;
  font-family: sans-serif;
  background-color: #f8f5ef;
}

.breadcrumb a {
  color: #000;
  text-decoration: none;
  font-weight: 500;
}

.breadcrumb .current {
  color: #aaa;
  font-style: italic;
}
</style>



<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($mon['tenmon']) ?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/chitietsanpham.css">
   <link rel="stylesheet" href="../css/index.css">
 
</head>
<body>
 <div class="product-detail">
  <div class="product-wrapper">
    <!-- Hình ảnh và caption -->
    <div class="product-image">
      <img src="../img/<?= $mon['hinhanh'] ?>" alt="<?= htmlspecialchars($mon['tenmon']) ?>">
      
      <!-- Ưu đãi & hỗ trợ -->
      <div class="caption-box">
        <p class="caption-title">🧾 Ưu đãi & hỗ trợ</p>
        <div class="divider"></div> <!-- Đường kẻ -->
        <p class="caption">🚚 Giao hàng miễn phí trong 24h</p>
        <p class="caption">💲 Thanh toán linh hoạt</p>
        <p class="caption">🔄 Hỗ trợ đổi món</p>
      </div>
       <a href="index.php" class="back-btn">⬅ Quay lại</a>
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="product-info">
      <h1><?= htmlspecialchars($mon['tenmon']) ?></h1>

      <p>
        <strong>Trạng thái: ✅</strong>
        <?php if (strtolower($mon['trangthai']) === 'còn hàng'): ?>
          <span style="color: green; font-weight: bold;"><?= htmlspecialchars($mon['trangthai']) ?></span>
        <?php else: ?>
          <span style="color: red; font-weight: bold;"><?= htmlspecialchars($mon['trangthai']) ?></span>
        <?php endif; ?>
      </p>

      <div class="price-box">
        <span class="label">Giá:</span>
        <span class="value"><?= number_format($mon['gia'], 0, ',', '.') ?>đ</span>
      </div>

      <div class="note">
        <strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($mon['ghichu'])) ?>
      </div>

      <p><strong>Danh mục:</strong> <?= htmlspecialchars($mon['tendanhmuc']) ?></p>

      <p>
        <strong>Đánh giá:</strong>
        <?php
          $rating = floatval($mon['sao']);
          $fullStars = floor($rating);
          $emptyStars = 5 - $fullStars;

          echo str_repeat('⭐', $fullStars);
          echo str_repeat('☆', $emptyStars);
          echo " ({$rating}/5)";
          if ($mon['hot'] == 1) echo ' 🔥 HOT';
        ?>
      </p>

      <!-- Ưu đãi tích điểm -->
      <div class="promo-box">
        <div class="promo-title">
          🎁 Ưu đãi tích điểm – đổi quà!
          <a href="dangki.php" class="hover-link">✍️ Đăng Kí</a> ngay
        </div>
        <ul class="promo-list">
          <li>🌟 Tích <strong>10 điểm</strong> → <strong>Giảm 15%</strong> cho đơn hàng</li>
          <li>🌟 Tích <strong>20 điểm</strong> → <strong>Giảm 30%</strong> cho đơn hàng</li>
          <li>🌟 Tích <strong>30 điểm</strong> → <strong>Giảm 50%</strong> cho đơn hàng</li>
        </ul>
      </div>

     
<form method="POST" action="dathang.php">
  <input type="hidden" name="tenmon" value="<?= htmlspecialchars($mon['tenmon']) ?>">
  <input type="hidden" name="gia" value="<?= (int)$mon['gia'] ?>">
  <input type="hidden" name="hinhanh" value="<?= htmlspecialchars('../img/' . $mon['hinhanh']) ?>">
        
  <!-- Ghi chú món ăn -->
  <div class="note-box">
    <label for="ghichu"><strong>Ghi chú món ăn:</strong></label><br>
    <textarea id="ghichu" name="ghichu" rows="3" placeholder="Ví dụ: ít cay, không hành..." style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc;"></textarea>
  </div>
  
  <!-- Số lượng và đặt hàng -->
  <div class="order-box" style="margin-top: 15px;">
    <label for="soluong"><strong>Số lượng:</strong></label>
    <input type="number" id="soluong" name="soluong" min="1" value="1" oninput="checkQuantity()" style="width: 60px; padding: 6px; border-radius: 6px; border: 1px solid #ccc; margin-left: 10px;">
  </div>
  
  <div class="action-buttons">
    <button type="submit" class="order-btn2">🛒 Đặt hàng</button>
  </div>
</form>

    </div>
  </div>
</div>

  <!-- Món ăn cùng danh mục -->
   <h1 style="margin-top: 50px; text-align: center; font-size: 40px;">
  Sản phẩm liên quan 
</h1>
<?php if ($related_items): ?>
  <div class="related-container">
    <h1 class="related-title"></h1>
    <div class="product-grid">
      <?php foreach ($related_items as $item): ?>
        <?php
          $rating = floatval($item['sao'] ?? 4.5);
          $fullStars = floor($rating);
          $halfStar = $rating - $fullStars >= 0.5;
          $starHtml = str_repeat('⭐', $fullStars) . ($halfStar ? '✩' : '');

          $isHot = $item['hot'] == 1 || stripos($item['tenmon'], 'đặc biệt') !== false;
        ?>
        <div class="product-card">
          <a href="chitietsanpham.php?id=<?= $item['id'] ?>">
            <?php if ($isHot): ?>
              <div class="hot-badge">🔥 HOT</div>
            <?php endif; ?>
            <img src="../img/<?= htmlspecialchars($item['hinhanh']) ?>" alt="<?= htmlspecialchars($item['tenmon']) ?>">
            <h4><?= htmlspecialchars($item['tenmon']) ?></h4>
            <div class="price"><?= number_format($item['gia'], 0, ',', '.') ?>đ</div>

            <div class="note"><?= htmlspecialchars($item['ghichu']) ?></div>
            <div class="rating"><?= $starHtml ?> <span class="rating-number">(<?= $rating ?>/5)</span></div>
            <button class="order-btn-small">ĐẶT NGAY</button>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

<!-- sản phẩm cùng mức giá  -->

 <h1 style="margin-top: 50px; text-align: center; font-size: 40px;">
  Sản phẩm cùng phân khúc 
  
</h1>
  <?php if ($same_price_items): ?>
  <div class="related-container">
    <h1 class="related-title"></h1>
    <div class="product-grid">
      <?php foreach ($same_price_items as $item): ?>
        <?php
          $rating = floatval($item['sao'] ?? 4.5);
          $fullStars = floor($rating);
          $halfStar = $rating - $fullStars >= 0.5;
          $starHtml = str_repeat('⭐', $fullStars) . ($halfStar ? '✩' : '');

          $isHot = $item['hot'] == 1 || stripos($item['tenmon'], 'đặc biệt') !== false;
        ?>
        <div class="product-card">
          <a href="chitietsanpham.php?id=<?= $item['id'] ?>">
            <?php if ($isHot): ?>
              <div class="hot-badge">🔥 HOT</div>
            <?php endif; ?>
            <img src="../img/<?= htmlspecialchars($item['hinhanh']) ?>" alt="<?= htmlspecialchars($item['tenmon']) ?>">
            <h4><?= htmlspecialchars($item['tenmon']) ?></h4>
            <div class="price"><?= number_format($item['gia'],0,',','.') ?>đ</div>
            <div class="note"><?= htmlspecialchars($item['ghichu']) ?></div>
            <div class="rating"><?= $starHtml ?> <span class="rating-number">(<?= $rating ?>/5)</span></div>
            <button class="order-btn-small">ĐẶT NGAY</button>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>


</body>
<script>
  function checkQuantity() {
    const input = document.getElementById("soluong");
    if (parseInt(input.value) < 1 || isNaN(input.value)) {
      input.value = 1;
    }
  }
</script>

</html>
