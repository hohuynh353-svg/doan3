<!-- quenmatkhau.php -->
<?php
session_start();


require 'connect.php';
require 'sendmail.php'; // Tí nữa mình sẽ tạo file này

// Đặt múi giờ PHP và MySQL
date_default_timezone_set('Asia/Ho_Chi_Minh'); // ⏰ Cho PHP
$conn->query("SET time_zone = '+07:00'");     // ⏰ Cho MySQL

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Kiểm tra email có trong hệ thống không
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Tạo token ngẫu nhiên
        $token = bin2hex(random_bytes(16));
        $expiration = date("Y-m-d H:i:s", time() + 3600); // hết hạn sau 1 giờ

        // Lưu token vào database
        $update = $conn->prepare("UPDATE users SET reset_token = ?, token_expire = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expiration, $email);
        $update->execute();

        // Gửi email xác nhận
        if (sendResetEmail($email, $token)) {
            $message = "✅ Đã gửi link đặt lại mật khẩu. Vui lòng kiểm tra email.";
        } else {
            $message = "❌ Gửi email thất bại. Kiểm tra cài đặt SMTP.";
        }
    } else {
        $message = "❌ Email không tồn tại trong hệ thống.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu</title>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background: radial-gradient(circle at top left, #efe8e8ff, #f0e8e8ff);
      font-family: 'Be Vietnam Pro', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      position: relative;
      background: #121212;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(255, 200, 0, 0.2);
      width: 400px;
      text-align: center;
      color: white;
    }

    .form-container h2 {
      color: #ffc107;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .form-container p {
      color: #ccc;
      margin-bottom: 30px;
    }

    .form-container input[type="email"] {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #444;
      background-color: #F0FFFF;
      color: white;
      font-size: 14px;
      margin-bottom: 20px;
      outline: none;
      transition: border 0.3s ease;
    }

    .form-container input[type="email"]:focus {
      border: 1px solid #ffcc00;
    }

    .form-container input[type="submit"] {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: none;
  font-weight: bold;
  background: linear-gradient(to right, #ffc107, #ff9800);
  color: black;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(255, 193, 7, 0.2);
}

.form-container input[type="submit"]:hover {
  background: linear-gradient(to right, #ffd700, #ff6f00);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(255, 193, 7, 0.4);
}


    .form-container .message {
      margin-top: 15px;
      color: #ff6666;
    }

    .close-btn {
      position: absolute;
      top: 12px;
      right: 18px;
      font-size: 24px;
      color: #ffcc00;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .close-btn:hover {
      color: #ff6600;
    }
  </style>
</head>
<body>

<div class="form-container">
  <div class="close-btn" onclick="window.location.href='dangnhap.php'">X</div>

  <form method="POST" class="form-box">
    <h2>🔐 Quên mật khẩu</h2>
    <p>Nhập email để nhận liên kết đặt lại mật khẩu</p>
    <input type="email" name="email" placeholder="Nhập email..." required>
    <input type="submit" value="Gửi yêu cầu">
    <div class="message"><?= $message ?? '' ?></div>
  </form>
</div>

</body>
</html>

