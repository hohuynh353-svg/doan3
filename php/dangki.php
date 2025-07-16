<?php
session_start();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'connect.php';

    $hoten = trim($_POST['hoten'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sdt = trim($_POST['sdt'] ?? '');
    $matkhau = $_POST['matkhau'] ?? '';
    $confirm_matkhau = $_POST['confirm_matkhau'] ?? '';

    // Validate
    if (empty($hoten)) $errors[] = "Vui lòng nhập họ và tên.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $errors[] = "Email không hợp lệ.Vui lòng nhập lại!";
    }
    if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
        $errors[] = "Số điện thoại không hợp lệ.Vui lòng nhập lại!";
    }
    if (strlen($matkhau) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
    if ($matkhau !== $confirm_matkhau) $errors[] = "Xác nhận mật khẩu không khớp.";

    if (empty($errors)) {
        // Check trùng email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email đã tồn tại.";
        } else {
            $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);
            $role = ($email === 'comnha@gmail.com') ? 'admin' : 'khachhang';
            $diemtichluy = 0;

            $insert = $conn->prepare("INSERT INTO users (hoten, email, sdt, matkhau, role, diemtichluy) 
                                      VALUES (?, ?, ?, ?, ?, ?)");
            $insert->bind_param("sssssi", $hoten, $email, $sdt, $hashed_password, $role, $diemtichluy);

            if ($insert->execute()) {
                echo "<script>alert('Đăng ký thành công!'); window.location.href='index.php';</script>";
                exit;
            } else {
                $errors[] = "Lỗi khi đăng ký: " . $conn->error;
            }

            $insert->close();
        }

        $stmt->close();
        $conn->close();
    }

    // Nếu có lỗi thì hiện alert và quay lại form
    if (!empty($errors)) {
        $message = implode("\\n", $errors); // xuống dòng
        echo "<script>alert('$message'); history.back();</script>";
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Ký</title>
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

    .form-container {
      background-color: #111;
      color: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
      width: 420px;
      position: relative;
    }

    .form-container h2 {
      text-align: center;
      color: #ffc107;
      margin-bottom: 24px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #ffc107;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #444;
      background-color: #222;
      color: white;
      outline: none;
      transition: border-color 0.3s ease;
    }

    input:focus {
      border-color: #ffc107;
      box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.3);
    }

    button {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: bold;
      background: linear-gradient(to right, #ffc107, #ff9800);
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(255, 193, 7, 0.2);
      transition: all 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #ffd700, #ff6f00);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(255, 193, 7, 0.4);
    }

    .register-link {
      text-align: center;
      margin-top: 12px;
      font-size: 14px;
    }

    .register-link a {
      color: #ffc107;
      text-decoration: none;
      font-weight: bold;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  color: #ffcc00;
  cursor: pointer;
  transition: color 0.2s ease;
  z-index: 10;
}

.close-btn:hover {
  color: #ec1515;
}
    </style>
</head>
<body>
    <div class="form-container">
    <div class="close-btn" onclick="window.location.href='index.php'">&times;</div>
    <h2>Đăng Ký Tài Khoản</h2>

    <form action="dangki.php" method="POST" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="hoten">Họ và Tên:</label>
        <input type="text" id="hoten" name="hoten" required placeholder="Nhập họ và tên">
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Nhập email">
      </div>

      <div class="form-group">
        <label for="sdt">Số điện thoại:</label>
        <input type="text" id="sdt" name="sdt" required pattern="\d{10,11}" placeholder="Nhập số điện thoại">
      </div>

      <div class="form-group">
        <label for="matkhau">Mật Khẩu:</label>
        <input type="password" id="matkhau" name="matkhau" required minlength="6" placeholder="Nhập mật khẩu">
      </div>

      <div class="form-group">
        <label for="confirm_matkhau">Xác Nhận Mật Khẩu:</label>
        <input type="password" id="confirm_matkhau" name="confirm_matkhau" required placeholder="Xác nhận mật khẩu">
      </div>

      <div class="form-group">
        <button type="submit">Đăng Ký</button>
      </div>

      <div class="register-link">
        Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a>
      </div>
    </form>
  </div>
    <script src="dangki.js"></script>
</body>
</html>