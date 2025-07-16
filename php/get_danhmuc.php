<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=webcomnha2;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT madanhmuc, tendanhmuc FROM danhmucmon ORDER BY madanhmuc ASC");
    $danhmucList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($danhmucList);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Lỗi kết nối: ' . $e->getMessage()]);
}
?>
