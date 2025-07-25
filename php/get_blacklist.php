<?php
require 'connect.php';

$sql = "SELECT sdt, solan_fail, trangthai FROM so_bi_chan ORDER BY solan_fail DESC";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE);
