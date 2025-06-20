<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $hoten = trim($_POST['tennv'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sdt = trim($_POST['sdt'] ?? '');
    $diachi = trim($_POST['diachi'] ?? '');
    $chucvu = trim($_POST['chucvu'] ?? '');
    $gioitinh = trim($_POST['gioitinh'] ?? '');

    if (empty($hoten) || empty($email) || empty($sdt)) {
        echo json_encode(['success' => false, 'error' => 'Vui lòng nhập đầy đủ thông tin.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Email không hợp lệ.']);
        exit;
    }

    if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
        echo json_encode(['success' => false, 'error' => 'Số điện thoại không hợp lệ.']);
        exit;
    }

    if ($action === 'add_nhanvien') {
        $stmt = $conn->prepare("SELECT id FROM nhanvien WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['success' => false, 'error' => 'Email đã tồn tại']);
            exit;
        }
        $stmt->close();

        $created_at = date('Y-m-d H:i:s');

        $insert = $conn->prepare("INSERT INTO nhanvien (tennv, email, sdt, diachi, chucvu, gioitinh, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssss", $hoten, $email, $sdt, $diachi, $chucvu, $gioitinh, $created_at);
        $success = $insert->execute();
        $insert->close();

        echo json_encode(['success' => $success]);
        exit;

    } elseif ($action === 'edit_nhanvien') {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'error' => 'ID không hợp lệ']);
            exit;
        }

        $update = $conn->prepare("UPDATE nhanvien SET tennv = ?, email = ?, sdt = ?, diachi = ?, chucvu = ?, gioitinh = ? WHERE id = ?");
        $update->bind_param("ssssssi", $hoten, $email, $sdt, $diachi, $chucvu, $gioitinh, $id);
        $success = $update->execute();
        $update->close();

        echo json_encode(['success' => $success]);
        exit;

    } elseif ($action === 'delete_nhanvien') {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'error' => 'ID không hợp lệ']);
            exit;
        }

        $delete = $conn->prepare("DELETE FROM nhanvien WHERE id = ?");
        $delete->bind_param("i", $id);
        $success = $delete->execute();
        $delete->close();

        echo json_encode(['success' => $success]);
        exit;

    } else {
        echo json_encode(['success' => false, 'error' => 'Action không hợp lệ']);
        exit;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM nhanvien ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Lỗi truy vấn']);
        exit;
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;

} else {
    echo json_encode(['success' => false, 'error' => 'Phương thức không được hỗ trợ']);
    exit;
}
