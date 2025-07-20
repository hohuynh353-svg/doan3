<?php
include 'connect.php';

$id = $_POST['id'];
$trangthai = $_POST['trangthai'];

$sql = "UPDATE donhang SET trangthai = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $trangthai, $id);

if ($stmt->execute()) {
  echo "OK";
} else {
  echo "Lỗi: " . $stmt->error;
}
