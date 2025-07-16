<?php
// Kết nối database

class Database {
    private $host = 'localhost';
    private $dbname = 'webcomnha2';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", 
                                  $this->username, 
                                  $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Lỗi kết nối: ' . $e->getMessage()]);
            exit;
        }
    }
}

// Class quản lý khách hàng
class CustomerManager {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email, $excludeId = null) {
        try {
            if ($excludeId) {
                $query = "SELECT id FROM users WHERE email = ? AND id != ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$email, $excludeId]);
            } else {
                $query = "SELECT id FROM users WHERE email = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$email]);
            }
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return true; // Gặp lỗi thì giả định là có tồn tại để chặn lại
        }
    }

    public function getAllCustomers() {
        try {
            $query = "SELECT id, hoten, email, sdt, diemtichluy, created_at FROM users WHERE role = 'khachhang' ORDER BY created_at ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Lỗi truy vấn: ' . $e->getMessage()]);
            return [];
        }
    }

    public function addCustomer($hoten, $email, $sdt, $matkhau) {
        // Validate dữ liệu
        if (empty($hoten) || empty($email) || empty($sdt) || empty($matkhau)) {
            return ['success' => false, 'error' => 'Vui lòng nhập đầy đủ thông tin'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
            return ['success' => false, 'error' => 'Email không hợp lệ. Vui lòng nhập đúng email @gmail.com'];
        }

        if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
            return ['success' => false, 'error' => 'Số điện thoại không hợp lệ'];
        }

        if ($this->emailExists($email)) {
            return ['success' => false, 'error' => 'Email đã tồn tại'];
        }

        try {
            $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (hoten, email, sdt, matkhau, role, diemtichluy, created_at) VALUES (?, ?, ?, ?, 'khachhang', 0, NOW())";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute([$hoten, $email, $sdt, $hashedPassword]);
            return ['success' => $success];
        } catch(PDOException $e) {
            return ['success' => false, 'error' => 'Lỗi thêm khách hàng: ' . $e->getMessage()];
        }
    }

    public function updateCustomer($id, $hoten, $email, $sdt) {
        if (empty($hoten) || empty($email) || empty($sdt) || intval($id) <= 0) {
            return ['success' => false, 'error' => 'Dữ liệu không hợp lệ'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
            return ['success' => false, 'error' => 'Email không hợp lệ'];
        }

        if (!preg_match('/^(03|07|08|09)[0-9]{8}$/', $sdt)) {
            return ['success' => false, 'error' => 'Số điện thoại không hợp lệ'];
        }

        if ($this->emailExists($email, $id)) {
            return ['success' => false, 'error' => 'Email đã tồn tại cho người dùng khác'];
        }

        try {
            $query = "UPDATE users SET hoten = ?, email = ?, sdt = ? WHERE id = ? AND role = 'khachhang'";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute([$hoten, $email, $sdt, $id]);
            return ['success' => $success];
        } catch(PDOException $e) {
            return ['success' => false, 'error' => 'Lỗi cập nhật: ' . $e->getMessage()];
        }
    }

    public function deleteCustomer($id) {
        try {
            $query = "DELETE FROM users WHERE id = ? AND role = 'khachhang'";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute([$id]);
            return ['success' => $success];
        } catch(PDOException $e) {
            return ['success' => false, 'error' => 'Lỗi xóa khách hàng: ' . $e->getMessage()];
        }
    }
}

// Xử lý AJAX requests
if (isset($_POST['action'])) {
    $customerManager = new CustomerManager();
    $action = $_POST['action'];

    switch ($action) {
        case 'get_customers':
            $customers = $customerManager->getAllCustomers();
            echo json_encode($customers);
            break;

        case 'add_customer':
            $result = $customerManager->addCustomer(
                trim($_POST['hoten'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['sdt'] ?? ''),
                $_POST['matkhau'] ?? ''
            );
            echo json_encode($result);
            break;

        case 'update_customer':
            $result = $customerManager->updateCustomer(
                intval($_POST['id'] ?? 0),
                trim($_POST['hoten'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['sdt'] ?? '')
            );
            echo json_encode($result);
            break;

        case 'delete_customer':
            $result = $customerManager->deleteCustomer(intval($_POST['id'] ?? 0));
            echo json_encode($result);
            break;
    }
    exit;
}
?>
