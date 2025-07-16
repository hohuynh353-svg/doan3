<?php
require 'connect.php';

// Đảm bảo múi giờ Việt Nam trong PHP và MySQL
date_default_timezone_set('Asia/Ho_Chi_Minh');
$conn->query("SET time_zone = '+07:00'");

session_start();

// Lấy token từ URL
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("⛔ Token không hợp lệ.");
}

// Kiểm tra token có hợp lệ và chưa hết hạn
$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expire > NOW()");
if (!$stmt) {
    die("❌ Lỗi truy vấn: " . $conn->error);
}
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("⛔ Liên kết không hợp lệ hoặc đã hết hạn. Hãy yêu cầu gửi lại email đặt lại mật khẩu.");
}

// Nếu người dùng gửi form đặt lại mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        $error = "⚠️ Mật khẩu không khớp!";
    } elseif (strlen($new_password) < 6) {
        $error = "⚠️ Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu mới và xóa token
        $update = $conn->prepare("UPDATE users SET matkhau = ?, reset_token = NULL, token_expire = NULL WHERE id = ?");
        if ($update) {
            $update->bind_param("si", $hashed, $user['id']);
            $update->execute();
            $success = "✅ Đặt lại mật khẩu thành công! Bạn có thể <a href='dangnhap.php'>đăng nhập</a>.";
        } else {
            $error = "❌ Có lỗi khi cập nhật mật khẩu. Vui lòng thử lại.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt lại mật khẩu</title>
  <style>
    body {
      background: radial-gradient(circle, #efe8e8ff, #f0e8e8ff);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .reset-container {
      background: #111;
      color: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
      width: 400px;
      position: relative;
    }

    .reset-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ffb300;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #ffc107;
    }

    input[type="password"] {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #444;
      background: #F0FFFF;
      color: black;
      outline: none;
      transition: border-color 0.3s;
    }

    input[type="password"]:focus {
      border-color: #ffc107;
      box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.4);
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      font-weight: bold;
      font-size: 16px;
      border-radius: 8px;
      border: none;
      background: linear-gradient(to right, #ffc107, #ff9800);
      color: black;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(255, 193, 7, 0.2);
    }

    button:hover {
      background: linear-gradient(to right, #ffd700, #ff6f00);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(255, 193, 7, 0.4);
    }

    .msg-success {
      color: #4caf50;
      margin-bottom: 10px;
    }

    .msg-error {
      color: #f44336;
      margin-bottom: 10px;
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

  <div class="reset-container">
    <div class="close-btn" onclick="window.location.href='dangnhap.php'">&times;</div>
    <h2>🔐 Đặt lại mật khẩu</h2>

    <?php if (isset($error)) echo "<p class='msg-error'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='msg-success'>$success</p>"; ?>

    <?php if (!isset($success)) { ?>
    <form method="post">
      <label for="new_password">Mật khẩu mới:</label>
      <input type="password" name="new_password" id="new_password" required>

      <label for="confirm_password">Nhập lại mật khẩu:</label>
      <input type="password" name="confirm_password" id="confirm_password" required>

      <button type="submit">Đặt lại mật khẩu</button>
    </form>
    <?php } ?>
  </div>

</body>
</html>
