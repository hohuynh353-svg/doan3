<?php
include 'connect.php';

$sql = "SELECT * FROM lienhe ORDER BY ngaylienhe ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['hoten']}</td>
            <td>{$row['email']}</td>
            <td>{$row['sdt']}</td>
            <td>{$row['noidung']}</td>
            <td>{$row['ngaylienhe']}</td>
            <td>
                <button class='btn btn-danger' onclick='xoaLienHe({$row['id']})'>Xóa</button>
            </td>
          </tr>";
}

$conn->close();
?>

<script>
function xoaLienHe(id) {
    if (confirm("Bạn có chắc chắn muốn xóa liên hệ này không?")) {
        window.location.href = "xoa_lienhe.php?id=" + id;
    }
}
</script>
