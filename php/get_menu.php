<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'webcomnha2';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ✅ Đúng tên bảng danh mục
$stmt_dm = $conn->prepare("SELECT madanhmuc, tendanhmuc FROM danhmucmon");
$stmt_dm->execute();
$danhmucs = $stmt_dm->fetchAll(PDO::FETCH_ASSOC);


// 2. Tạo cấu trúc danh mục ban đầu
$grouped_menu = [];
foreach ($danhmucs as $dm) {
    $id = $dm['madanhmuc'];
    $grouped_menu[$id] = [
        "tendanhmuc" => $dm['tendanhmuc'],
        "monan" => []
    ];
}

// 3. Lấy toàn bộ món ăn
$stmt = $conn->prepare("SELECT id, tenmon, gia, hinhanh, danhmucmon, ghichu, sao, hot FROM menu ORDER BY danhmucmon ASC, id DESC");
$stmt->execute();
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Đưa món ăn vào đúng danh mục
foreach ($menu as $item) {
    $danhmuc_id = $item['danhmucmon'];
    if (isset($grouped_menu[$danhmuc_id])) {
        $grouped_menu[$danhmuc_id]['monan'][] = $item;
    }
}

// 5. Trả về JSON
header('Content-Type: application/json');
echo json_encode($grouped_menu);


?>
