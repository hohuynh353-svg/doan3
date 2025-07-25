<?php
require 'connect.php';

// Xử lý mở chặn nếu admin nhấn nút
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mochan'])) {
    $sdt = $_POST['sdt'];

    // Đặt lại trạng thái và số lần fail
    $sql = "UPDATE so_bi_chan SET trangthai = 'binhthuong', solan_fail = 0 WHERE sdt = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sdt);
    $stmt->execute();

    echo "<script>alert('✅ Đã mở chặn cho số: $sdt');</script>";
}

// Lấy danh sách số bị chặn
$sql = "SELECT * FROM so_bi_chan ORDER BY solan_fail DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh Sách Số Bị Chặn</title>
  <style>
    body {
        font-family: Arial;
        background: #f4f4f4;
        padding: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #007bff;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    form {
        display: inline-block;
    }
    button {
        padding: 6px 10px;
        background-color: #28a745;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 4px;
    }
    button:hover {
        background-color: #218838;
    }
    .label {
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: bold;
    }
    .binhthuong { background: #d1ecf1; color: #0c5460; }
    .canhbao { background: #fff3cd; color: #856404; }
    .chan { background: #f8d7da; color: #721c24; }
  </style>
</head>
<body>

<h2>📵 Danh Sách Số Bị Cảnh Báo / Chặn</h2>

<table>
  <thead>
    <tr>
      <th>Số điện thoại</th>
      <th>Số lần giao không thành công</th>
      <th>Trạng thái</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['sdt']) ?></td>
        <td><?= $row['solan_fail'] ?></td>
        <td>
          <span class="label <?= $row['trangthai'] ?>">
            <?= strtoupper($row['trangthai']) ?>
          </span>
        </td>
        <td>
          <?php if ($row['trangthai'] === 'chan'): ?>
            <form method="POST">
              <input type="hidden" name="sdt" value="<?= $row['sdt'] ?>">
              <button type="submit" name="mochan">Mở chặn</button>
            </form>
          <?php else: ?>
            <i style="color: gray;">Không cần mở</i>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
