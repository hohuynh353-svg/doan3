<?php
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$trangthai = $data['trangthai'];

$sql = "UPDATE donhang SET trangthai = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $trangthai, $id);
$stmt->execute();

echo "Cập nhật thành công";
