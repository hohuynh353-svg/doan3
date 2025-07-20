<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $matkhau = $_POST['matkhau'] ?? '';

    if (empty($email) || empty($matkhau)) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.history.back();</script>";
        exit;
    }

    // Tìm người dùng theo email
    $query = "SELECT id, hoten, email, matkhau, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($matkhau, $user['matkhau'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['hoten'] = $user['hoten'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Chuyển hướng theo quyền
            if ($user['role'] === 'admin') {
                echo "<script>alert('Đăng nhập thành công (Admin)'); window.location.href = 'admin.php';</script>";
            } elseif ($user['role'] === 'nhanvien') {
                 $_SESSION['nhanvien_taikhoan'] = $user['hoten']; // <-- thêm dòng này
                echo "<script>alert('Đăng nhập thành công (Nhân viên)'); window.location.href = 'nhanvien.php';</script>";
            } else {
                echo "<script>alert('Đăng nhập thành công (Khách hàng)'); window.location.href = 'index.php';</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu không đúng.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email không tồn tại.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Nhập</title>
  <link rel="stylesheet" href="../css/dangnhap.css">
</head>
<body>
    
    <div class="form-container">
        <div class="close-btn" onclick="window.location.href='index.php'">X</div>


    <h2>Đăng Nhập</h2>
    <p>Chào mừng bạn trở lại</p>
    <form action="dangnhap.php" method="POST" onsubmit="return validateLoginForm()">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Nhập email">
        <span class="error-message" id="email-error">Email không hợp lệ</span>
      </div>

      <div class="form-group">
        <label for="matkhau">Mật Khẩu:</label>
        <input type="password" id="matkhau" name="matkhau" required placeholder="Nhập mật khẩu">
        <span class="error-message" id="password-error">Mật khẩu không được để trống</span>
      </div>

      <div class="forgot-password">
        <a href="quenmatkhau.php">Quên mật khẩu?</a>
      </div>

      <button type="submit">ĐĂNG NHẬP</button>

      <div class="register-link">
        Nếu bạn chưa có tài khoản, hãy <a href="dangki.php">Đăng ký ngay</a>
      </div>
    </form>
  </div>

    <script>
        function validateLoginForm() {
            let isValid = true;
            const email = document.getElementById('email');
            const matkhau = document.getElementById('matkhau');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');

            // Reset error messages
            emailError.style.display = 'none';
            passwordError.style.display = 'none';

            // Validate email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                emailError.style.display = 'block';
                isValid = false;
            }

            // Validate password (not empty)
            if (matkhau.value.trim() === '') {
                passwordError.style.display = 'block';
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>