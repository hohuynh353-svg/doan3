<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: dangnhap.php");
  exit();
}

include 'connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM donhang WHERE user_id = $user_id ORDER BY thoigian DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đơn Hàng Của Tôi</title>
  <style>
    body {
      font-family: Arial;
      background: #f2f2f2;
      padding: 30px;
    }
    h2 {
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: #4CAF50;
      color: white;
    }
    a.btn {
      background: #007bff;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 4px;
    }
    a.btn:hover {
      background: #0056b3;
    }
    /* Modal */
.modal {
  position: fixed;
  z-index: 9999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.6); /* làm mờ nền */
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Ẩn modal ban đầu */
.modal.hidden {
  display: none;
}

.modal-content {
  background: #fff;
  padding: 30px;
  max-width: 800px;
  width: 95%;
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  position: relative;
}
/* CSS cho modal overlay */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3); /* nền mờ */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

/* Ẩn modal */
.hidden {
  display: none;
}

/* CSS cho phần nội dung bên trong modal */
.modal-content {
  background: white;
  max-width: 700px;
  width: 90%;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  max-height: 90vh;
  overflow-y: auto;
  animation: fadeIn 0.25s ease-in-out;
}

/* Hiệu ứng hiện mượt */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}


/* Nút đóng */
.modal-content .close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
}
/* Nút Quay lại (màu nhạt) */
.back-btn {
  background-color: white;
  color: #ff4500;
  border: 1px solid #ff4500;
  padding: 6px 20px; /* Chiều cao bằng nút đặt hàng */
  font-size: 16px;
  border-radius: 6px; /* Cho đồng bộ */
  cursor: pointer;
  font-weight: bold;
  text-decoration: none; /* Bỏ gạch chân link */
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.2s, color 0.2s;
  width: 100px;
  margin-bottom: 20px; /* Khoảng cách dưới */
  margin-top: 8px; /* Khoảng cách trên */
}

.back-btn:hover {
  background-color: #fff5f0;
  color: #e03d00;
}


  </style>
</head>
<body>

<h1 style="text-align:center;">📦 Đơn Hàng Của Tôi</h1>
 
<table>
  <thead>
    <tr>
      <th>Mã Đơn</th>
      <th>Ngày Đặt</th>
      <th>Trạng Thái</th>
      <th>Tổng Tiền</th>
      <th>Thao Tác</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td>#<?= $row['id'] ?></td>
        <td><?= date("d/m/Y H:i", strtotime($row['thoigian'])) ?></td>
        <td><?= $row['trangthai'] ?></td>
        <td><?= number_format($row['tongtien'], 0, '.', '.') ?>đ</td>
        <td>
        <a href="javascript:void(0);" class="btn btn-info btn-xem" data-id="<?= $row['id'] ?>">Xem</a>

        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<!-- Modal hiển thị chi tiết đơn hàng -->
<div id="order-detail-modal" class="modal hidden">
  <div class="modal-content" id="order-detail-content">
    <!-- Nội dung chi tiết đơn hàng sẽ được load ở đây -->
  </div>
</div>
<a href="taikhoannguoidung.php" class="back-btn">⬅ Quay lại</a>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".btn-xem");
  const modal = document.getElementById("order-detail-modal");
  const modalContent = document.getElementById("order-detail-content");

  buttons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const id = this.getAttribute("data-id");

      fetch("get_order_detail.php?id=" + id)
        .then((res) => res.text())
        .then((html) => {
          modalContent.innerHTML = html;
          modal.classList.remove("hidden");
        })
        .catch(() => {
          modalContent.innerHTML = "<p>Lỗi khi tải đơn hàng!</p>";
          modal.classList.remove("hidden");
        });
    });
  });

  // Đóng modal khi bấm nút X
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("close-btn") || e.target === modal) {
      modal.classList.add("hidden");
    }
  });
});
</script>
<script>
function huyDon(id) {
  if (!confirm("Bạn chắc chắn muốn hủy đơn hàng này?")) return;

  fetch('huydon.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'donhang_id=' + encodeURIComponent(id)
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    location.reload();
  })
  .catch(error => {
    console.error('Lỗi khi gửi yêu cầu:', error);
    alert("Đã có lỗi xảy ra.");
  });
}
</script>

</body>

</html>
