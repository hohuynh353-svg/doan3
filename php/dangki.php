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
                Nếu bạn chưa có tài khoản, hãy <a href="dangnhap.php">đăng nhập</a>
            </div>
</form>

    </div>
    <script src="dangki.js"></script>
</body>
</html>