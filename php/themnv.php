<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add_nhanvien':
            $hoten = trim($_POST['hoten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');
            $chucvu = trim($_POST['chucvu'] ?? '');
            $matkhau_raw = $_POST['matkhau'] ?? '';

            if (empty($hoten) || empty($email) || empty($sdt) || empty($chucvu) || empty($matkhau_raw)) {
                echo json_encode(['success' => false, 'error' => 'Vui lòng nhập đầy đủ thông tin']);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
                echo json_encode(['success' => false, 'error' => 'Email không hợp lệ. Vui lòng nhập lại!']);
                exit;
            }

            if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
                echo json_encode(['success' => false, 'error' => 'Số điện thoại không hợp lệ. Vui lòng nhập lại!']);
                exit;
            }

            // Check email tồn tại
            $stmt = $conn->prepare("SELECT id FROM nhanvien WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo json_encode(['success' => false, 'error' => 'Email đã tồn tại']);
                $stmt->close();
                exit;
            }
            $stmt->close();

            $matkhau = password_hash($matkhau_raw, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');

            $insert = $conn->prepare("INSERT INTO nhanvien (hoten, email, sdt, chucvu, matkhau, created_at) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->bind_param("ssssss", $hoten, $email, $sdt, $chucvu, $matkhau, $created_at);
            $success = $insert->execute();
            $insert->close();

            echo json_encode(['success' => $success]);
            exit;

        case 'edit_nhanvien':
            $id = intval($_POST['id'] ?? 0);
            $hoten = trim($_POST['hoten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');
            $chucvu = trim($_POST['chucvu'] ?? '');
            $matkhau_raw = $_POST['matkhau'] ?? '';

            if ($id <= 0 || empty($hoten) || empty($email) || empty($sdt) || empty($chucvu)) {
                echo json_encode(['success' => false, 'error' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
                echo json_encode(['success' => false, 'error' => 'Email không hợp lệ']);
                exit;
            }

            if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
                echo json_encode(['success' => false, 'error' => 'Số điện thoại không hợp lệ']);
                exit;
            }

            // Check email trùng (ngoại trừ chính nó)
            $stmt = $conn->prepare("SELECT id FROM nhanvien WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo json_encode(['success' => false, 'error' => 'Email đã tồn tại']);
                $stmt->close();
                exit;
            }
            $stmt->close();

            if (!empty($matkhau_raw)) {
                $matkhau = password_hash($matkhau_raw, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE nhanvien SET hoten = ?, email = ?, sdt = ?, chucvu = ?, matkhau = ? WHERE id = ?");
                $update->bind_param("sssssi", $hoten, $email, $sdt, $chucvu, $matkhau, $id);
            } else {
                $update = $conn->prepare("UPDATE nhanvien SET hoten = ?, email = ?, sdt = ?, chucvu = ? WHERE id = ?");
                $update->bind_param("ssssi", $hoten, $email, $sdt, $chucvu, $id);
            }

            $success = $update->execute();
            $update->close();

            echo json_encode(['success' => $success]);
            exit;

        case 'delete_nhanvien':
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

        default:
            echo json_encode(['success' => false, 'error' => 'Action không hợp lệ']);
            exit;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lấy danh sách nhân viên
    $sql = "SELECT id, hoten, email, sdt, chucvu, created_at FROM nhanvien ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Lỗi truy vấn: ' . $conn->error]);
        exit;
    }

    $staffs = [];
    while ($row = $result->fetch_assoc()) {
        $staffs[] = $row;
    }

    echo json_encode($staffs);
    exit;

} else {
    echo json_encode(['success' => false, 'error' => 'Phương thức không được hỗ trợ']);
    exit;
}
