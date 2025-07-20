<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($current) || empty($new) || empty($confirm)) {
        echo "<script>alert('Vui lòng nhập đầy đủ.'); history.back();</script>";
        exit;
    }

    if ($new !== $confirm) {
        echo "<script>alert('Mật khẩu mới không khớp.'); history.back();</script>";
        exit;
    }

    $id = $_SESSION['user_id'];
    $query = "SELECT matkhau FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!password_verify($current, $user['matkhau'])) {
        echo "<script>alert('Mật khẩu hiện tại không đúng.'); history.back();</script>";
        exit;
    }

    $newHashed = password_hash($new, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET matkhau = ? WHERE id = ?");
    $update->bind_param("si", $newHashed, $id);
    $update->execute();

    echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='hoso.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đổi mật khẩu</title>
<style>
  .change-password-form {
    position: relative;
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px 35px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
  }

  .change-password-form h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
  }

  .change-password-form input[type="password"],
  .change-password-form input[type="submit"] {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
  }

  .change-password-form input[type="password"]:focus {
    border-color: #66afe9;
    outline: none;
  }

  .change-password-form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .change-password-form input[type="submit"]:hover {
    background-color: #f33a1eff;
  }

  .close-button {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 22px;
    color: #f00
    ;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.2s ease;
  }


</style>

</head>
<body>
<form method="POST" class="change-password-form">
  <button class="close-button" onclick="window.location.href='nhanvien.php'" type="button">X</button>
  <h2>Đổi mật khẩu</h2>
  <input type="password" name="current_password" placeholder="Mật khẩu hiện tại" required>
  <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
  <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
  <input type="submit" value="Xác nhận">
</form>
</body>
</html>
