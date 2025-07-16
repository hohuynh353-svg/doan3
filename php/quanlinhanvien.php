<?php
header("Content-Type: application/json");
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Thông tin kết nối
$host = "localhost";
$user = "root";
$password = "";
$database = "webcomnha2"; // thay tên database của bạn

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Kết nối CSDL thất bại."]));
}

$action = isset($_GET["action"]) ? $_GET["action"] : "";

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@gmail\\.com$/', $email);
}

function isValidPhone($phone) {
    return preg_match('/^(03|07|08|09)[0-9]{8}$/', $phone);
}

if ($action == "get") {
    $sql = "SELECT * FROM nhanvien";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    exit();
}

if ($action == "add") {
    $tennv = trim($_POST["tennv"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $sdt = trim($_POST["sdt"] ?? "");
    $diachi = trim($_POST["diachi"] ?? "");
    $chucvu = trim($_POST["chucvu"] ?? "");
    $gioitinh = trim($_POST["gioitinh"] ?? "");
    $ngaytao = date("Y-m-d H:i:s");

    if (!$tennv || !$email || !$sdt || !$diachi || !$chucvu || !$gioitinh) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"]);
        exit();
    }

    if (!isValidEmail($email)) {
        echo json_encode(["status" => "error", "message" => "Email không hợp lệ (@gmail.com)"]);
        exit();
    }

    if (!isValidPhone($sdt)) {
        echo json_encode(["status" => "error", "message" => "Số điện thoại không hợp lệ"]);
        exit();
    }

    // Kiểm tra email trùng
    $check = $conn->prepare("SELECT id FROM nhanvien WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email đã tồn tại"]);
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO nhanvien (tennv, email, sdt, diachi, chucvu, gioitinh, ngaytao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $tennv, $email, $sdt, $diachi, $chucvu, $gioitinh, $ngaytao);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
    exit();
}

if ($action == "update") {
    $id = intval($_POST["id"] ?? 0);
    $tennv = trim($_POST["tennv"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $sdt = trim($_POST["sdt"] ?? "");
    $diachi = trim($_POST["diachi"] ?? "");
    $chucvu = trim($_POST["chucvu"] ?? "");
    $gioitinh = trim($_POST["gioitinh"] ?? "");

    if ($id <= 0 || !$tennv || !$email || !$sdt || !$diachi || !$chucvu || !$gioitinh) {
        echo json_encode(["status" => "error", "message" => "Thiếu thông tin hoặc ID sai"]);
        exit();
    }

    if (!isValidEmail($email)) {
        echo json_encode(["status" => "error", "message" => "Email không hợp lệ"]);
        exit();
    }

    if (!isValidPhone($sdt)) {
        echo json_encode(["status" => "error", "message" => "Số điện thoại không hợp lệ"]);
        exit();
    }

    // Kiểm tra email trùng trừ ID hiện tại
    $check = $conn->prepare("SELECT id FROM nhanvien WHERE email = ? AND id != ?");
    $check->bind_param("si", $email, $id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email đã tồn tại cho nhân viên khác"]);
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("UPDATE nhanvien SET tennv=?, email=?, sdt=?, diachi=?, chucvu=?, gioitinh=? WHERE id=?");
    $stmt->bind_param("ssssssi", $tennv, $email, $sdt, $diachi, $chucvu, $gioitinh, $id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
    exit();
}

if ($action == "delete") {
    $id = intval($_POST["id"] ?? 0);
    if ($id <= 0) {
        echo json_encode(["status" => "error", "message" => "ID không hợp lệ"]);
        exit();
    }
    $stmt = $conn->prepare("DELETE FROM nhanvien WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
    exit();
}

// Nếu không có action hợp lệ
echo json_encode(["status" => "error", "message" => "Action không hợp lệ"]);

?>
