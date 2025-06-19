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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #e9ecef;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group input:invalid:focus:not(:placeholder-shown) {
            border-color: #dc3545;
        }
        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        .register-link {
            text-align: center;
            font-size: 14px;
            color: #007bff;
            margin-top: 10px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    
    <div class="form-container">
        <h2>Đăng Nhập</h2>
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
            <div class="form-group">
                <button type="submit">Đăng Nhập</button>
            </div>
            <div class="register-link">
                Nếu bạn chưa có tài khoản, hãy <a href="dangki.php">đăng ký</a>
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