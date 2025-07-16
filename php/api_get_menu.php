<?php
require_once 'connect.php';
$sql = "SELECT * FROM menu ORDER BY id DESC";
$result = $conn->query($sql);
$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($data);
?>
