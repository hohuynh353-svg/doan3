<?php
include 'connect.php';
// Lấy dữ liệu từ form

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Cần thêm dòng này
    $tennv = $_POST['tennv'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $chucvu = $_POST['chucvu'];
    $gioitinh = $_POST['gioitinh'];
    $ngaytao = date('Y-m-d H:i:s');

    // Cập nhật thông tin
    $sql = "UPDATE nhanvien SET 
        tennv='$tennv', 
        email='$email', 
        sdt='$sdt', 
        diachi='$diachi',
        chucvu='$chucvu',
        gioitinh='$gioitinh',
        ngaytao='$ngaytao'
        WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
}else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM nhanvien WHERE id='$id'";
    $result = $conn->query($sql);
    $employees = $result->fetch_assoc();
}
$conn->close();
?>

<!-- HTML hiển thị form sửa -->
<!DOCTYPE html>
<html>
<head>
    <title>Sửa nhân viên</title>
</head>
<body>
    <h3>Chỉnh sửa thông tin nhân viên</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $employees['id'] ?>">

        <label>Họ và tên:</label>
        <input type="text" name="tennv" value="<?= $employees['tennv'] ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $employees['email'] ?>" required><br>

        <label>Số điện thoại:</label>
        <input type="text" name="sdt" value="<?= $employees['sdt'] ?>" required><br>

        <label>Địa chỉ:</label>
        <input type="text" name="diachi" value="<?= $employees['diachi'] ?>" required><br>

        <label>Chức vụ:</label>
        <select name="chucvu">
            <option <?= $employees['chucvu'] == 'Đầu bếp' ? 'selected' : '' ?>>Đầu bếp</option>
            <option <?= $employees['chucvu'] == 'Phụ bếp' ? 'selected' : '' ?>>Phụ bếp</option>
            <option <?= $employees['chucvu'] == 'Giao hàng' ? 'selected' : '' ?>>Giao hàng</option>
        </select><br>

        <label>Giới tính:</label>
        <select name="gioitinh">
            <option <?= $employees['gioitinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option <?= $employees['gioitinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            <option <?= $employees['gioitinh'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
        </select><br>

        <button type="submit">Lưu</button>
        <a href="admin.php">Huỷ</a>
    </form>
</body>
</html>