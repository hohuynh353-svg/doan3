<?php
include 'connect.php';

$sql = "SELECT * FROM nhanvien ORDER BY id ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['tennv']}</td>
            <td>{$row['email']}</td>
            <td>{$row['sdt']}</td>
            <td>{$row['diachi']}</td>
            <td>{$row['chucvu']}</td>
            <td>{$row['gioitinh']}</td>
            <td>{$row['ngaytao']}</td>

            <td>
                <button class='btn btn-success' onclick='suaNhanVien({$row['id']})'>Sửa</button>
                <button class='btn btn-danger' onclick='xoaNhanVien({$row['id']})'>Xóa</button>
            </td>
          </tr>";
}

$conn->close();
?>

<script>
function suaNhanVien(id) {
    window.location.href = "sua_nv.php?id=" + id;
}
</script>

<script>
function xoaNhanVien(id) {
    if (confirm("Bạn có chắc chắn muốn xóa tour này không?")) {
        // Nếu đồng ý, chuyển hướng tới file PHP xử lý xóa
        window.location.href = "xoa_nv.php?id=" + id;
    }
    // Nếu chọn Cancel thì không làm gì
}
</script>




