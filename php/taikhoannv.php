<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_nhanvien') {
        // Phần thêm nhân viên bạn đã có
        $hoten = trim($_POST['hoten'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');
        $matkhau_raw = $_POST['matkhau'] ?? '';

        if (empty($hoten) || empty($email) || empty($sdt) || empty($matkhau_raw)) {
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

        // Kiểm tra email tồn tại
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Lỗi chuẩn bị câu truy vấn: ' . $conn->error]);
            exit;
        }
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
        $role = 'nhanvien';
        $created_at = date('Y-m-d H:i:s');

        $insert = $conn->prepare("INSERT INTO users (hoten, email, sdt, matkhau, role, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$insert) {
            echo json_encode(['success' => false, 'error' => 'Lỗi chuẩn bị câu truy vấn thêm: ' . $conn->error]);
            exit;
        }
        $insert->bind_param("ssssss", $hoten, $email, $sdt, $matkhau, $role, $created_at);
        $success = $insert->execute();
        $insert->close();

        echo json_encode(['success' => $success]);
        exit;

    } elseif ($action === 'edit_nhanvien') {
        // Sửa nhân viên
        $id = intval($_POST['id'] ?? 0);
        $hoten = trim($_POST['hoten'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');
        $matkhau_raw = $_POST['matkhau'] ?? ''; // Có thể để trống nếu không đổi mật khẩu

        if ($id <= 0 || empty($hoten) || empty($email) || empty($sdt)) {
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

        // Kiểm tra email đã tồn tại với id khác (để tránh trùng)
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Lỗi prepare: ' . $conn->error]);
            exit;
        }
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
            // Update có mật khẩu mới
            $matkhau = password_hash($matkhau_raw, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET hoten = ?, email = ?, sdt = ?, matkhau = ? WHERE id = ?");
            if (!$update) {
                echo json_encode(['success' => false, 'error' => 'Lỗi prepare: ' . $conn->error]);
                exit;
            }
            $update->bind_param("ssssi", $hoten, $email, $sdt, $matkhau, $id);
        } else {
            // Update không đổi mật khẩu
            $update = $conn->prepare("UPDATE users SET hoten = ?, email = ?, sdt = ? WHERE id = ?");
            if (!$update) {
                echo json_encode(['success' => false, 'error' => 'Lỗi prepare: ' . $conn->error]);
                exit;
            }
            $update->bind_param("sssi", $hoten, $email, $sdt, $id);
        }

        $success = $update->execute();
        $update->close();

        echo json_encode(['success' => $success]);
        exit;

    } elseif ($action === 'delete_nhanvien') {
        // Xóa nhân viên
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'error' => 'ID không hợp lệ']);
            exit;
        }

        $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
        if (!$delete) {
            echo json_encode(['success' => false, 'error' => 'Lỗi prepare: ' . $conn->error]);
            exit;
        }
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
    // Lấy danh sách nhân viên role = 'nhanvien'
    $sql = "SELECT id, hoten, email, sdt, created_at FROM users WHERE role = 'nhanvien' ORDER BY created_at ASC";
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
