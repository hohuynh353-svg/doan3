<?php
// Kết nối database
class Database {
    private $host = 'localhost';
    private $dbname = 'webcomnha2';     // ✅ Tên database đã cập nhật
    private $username = 'root';         // ✅ Tên người dùng
    private $password = '';             // ✅ Mật khẩu trống (như bạn nói, không có khoảng trắng)
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", 
                                  $this->username, 
                                  $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
            return null;
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
    
    // Lấy danh sách tất cả khách hàng
    public function getAllCustomers() {
        try {
            $query = "SELECT id, hoten, email, sdt, diemtichluy, created_at FROM users WHERE role = 'khachhang' ORDER BY created_at ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }
    
    // Thêm khách hàng mới
    public function addCustomer($hoten, $email, $sdt, $matkhau) {
        try {
            $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (hoten, email, sdt, matkhau, role, diemtichluy, created_at) VALUES (?, ?, ?, ?, 'khachhang', 0, NOW())";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$hoten, $email, $sdt, $hashedPassword]);
        } catch(PDOException $e) {
            echo "Lỗi thêm khách hàng: " . $e->getMessage();
            return false;
        }
    }
    
    // Cập nhật thông tin khách hàng
    public function updateCustomer($id, $hoten, $email, $sdt) {
        try {
            $query = "UPDATE users SET hoten = ?, email = ?, sdt = ? WHERE id = ? AND role = 'khachhang'";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$hoten, $email, $sdt, $id]);
        } catch(PDOException $e) {
            echo "Lỗi cập nhật: " . $e->getMessage();
            return false;
        }
    }
    
    // Xóa khách hàng
    public function deleteCustomer($id) {
        try {
            $query = "DELETE FROM users WHERE id = ? AND role = 'khachhang'";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            echo "Lỗi xóa khách hàng: " . $e->getMessage();
            return false;
        }
    }
}

// Xử lý AJAX requests
if (isset($_POST['action'])) {
    $customerManager = new CustomerManager();
    
    switch ($_POST['action']) {
        case 'get_customers':
            $customers = $customerManager->getAllCustomers();
            echo json_encode($customers);
            break;
            
        case 'add_customer':
            $result = $customerManager->addCustomer(
                $_POST['hoten'], 
                $_POST['email'], 
                $_POST['sdt'], 
                $_POST['matkhau']
            );
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_customer':
            $result = $customerManager->updateCustomer(
                $_POST['id'],
                $_POST['hoten'], 
                $_POST['email'], 
                $_POST['sdt']
            );
            echo json_encode(['success' => $result]);
            break;
            
        case 'delete_customer':
            $result = $customerManager->deleteCustomer($_POST['id']);
            echo json_encode(['success' => $result]);
            break;
            
    }
    exit;
}
?>