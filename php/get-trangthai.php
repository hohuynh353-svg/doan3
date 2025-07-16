<?php
require_once 'connect.php';

$result = $conn->query("SELECT trangthai FROM hethong LIMIT 1");
$row = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode([
    'trangthai' => $row['trangthai']
]);
