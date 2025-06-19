<?php
include 'connect.php';
include 'update_danhgia.php';

$sql = "SELECT * FROM danhgia ORDER BY ngaydanhgia ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['hoten']}</td>
            <td>{$row['noidung']}</td>
            <td>{$row['sosao']}</td>
            <td>{$row['ngaydanhgia']}</td>
            <td>";

    $selectHTML = "<select class='form-select' onchange='handleAction(this.value, {$row['id']})' id='action-select-{$row['id']}'>";
    $selectHTML .= "<option value='duyet'" . ($row['thaotac'] === 'duyet' ? " selected" : "") . ">Duyệt</option>";
    $selectHTML .= "<option value='an'" . ($row['thaotac'] === 'an' ? " selected" : "") . ">Ẩn</option>";
    $selectHTML .= "<option value='xoa'" . ($row['thaotac'] === 'xoa' ? " selected" : "") . ">Xóa</option>";
    $selectHTML .= "</select>";

    echo $selectHTML;

    echo "</td></tr>";
}

$conn->close();
?>
