<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit;
}

$id = intval($_SESSION['user_id']);
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Không tìm thấy thông tin nhân viên.";
    exit;
}

$nv = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hồ sơ nhân viên</title>
  <style>
body {
  background-color: #f4f6fc;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 40px 0; /* thêm khoảng cách từ trên xuống */
  display: flex;
  justify-content: center;
  /* align-items: center;  <-- bỏ dòng này */
  min-height: 100%; /* hoặc auto */
}


    .profile-card {
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      width: 400px;
      text-align: center;
    }

    .profile-avatar {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #6c63ff, #8a7dff);
      color: white;
      font-weight: bold;
      font-size: 28px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
    }

    .profile-name {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #333;
    }

    .profile-detail {
      text-align: left;
      margin-top: 20px;
    }

    .profile-detail p {
      margin: 10px 0;
      font-size: 15px;
      color: #555;
    }

    .profile-detail strong {
      color: #111;
    }
    .profile-card {
  position: relative;
  background: #fff;
  padding: 20px 24px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  max-width: 400px;
  margin: auto;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  background: transparent;
  border: none;
  font-size: 20px;
  color: #FF0000;
  cursor: pointer;
  transition: color 0.2s;
}


  </style>
</head>
<body>

<div class="profile-card">
  <button class="close-btn" onclick="window.location.href='nhanvien.php'">X</button>


  <div class="profile-avatar">
    <?= strtoupper(substr($nv['hoten'], 0, 1)) .
        strtoupper(substr(strrchr($nv['hoten'], " "), 1, 1)) ?>
  </div>
  <div class="profile-name"><?= htmlspecialchars($nv['hoten']) ?></div>

  <div class="profile-detail">
    <p><strong>Email:</strong> <?= htmlspecialchars($nv['email']) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($nv['sdt']) ?></p>
    <p><strong>Chức vụ:</strong> <?= htmlspecialchars($nv['role']) ?></p>
  </div>
</div>

 

</body>
</html>
