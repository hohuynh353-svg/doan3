<?php
// Kết nối database
date_default_timezone_set('Asia/Ho_Chi_Minh');

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
            echo json_encode(["error" => "Lỗi kết nối: " . $e->getMessage()]);
            exit;
        }
    }
}

// Class quản lý món ăn
class MenuManager {
    public $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllMenu() {
        try {
            $query = "SELECT m.*, d.tendanhmuc 
                      FROM menu m 
                      JOIN danhmucmon d ON m.danhmucmon = d.madanhmuc 
                      ORDER BY m.id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return ["error" => "Lỗi truy vấn: " . $e->getMessage()];
        }
    }

    public function addMenu($tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai) {
        try {
            $query = "INSERT INTO menu (tenmon, gia, hinhanh, danhmucmon, ghichu, trangthai, ngaytao)
                      VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai]);
        } catch(PDOException $e) {
            return false;
        }
    }

    public function updateMenu($id, $tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai) {
        try {
            if ($hinhanh !== null) {
                $query = "UPDATE menu 
                          SET tenmon=?, gia=?, hinhanh=?, danhmucmon=?, ghichu=?, trangthai=? 
                          WHERE id=?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai, $id]);
            } else {
                $query = "UPDATE menu 
                          SET tenmon=?, gia=?, danhmucmon=?, ghichu=?, trangthai=? 
                          WHERE id=?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$tenmon, $gia, $danhmucmon, $ghichu, $trangthai, $id]);
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    public function deleteMenu($id) {
        try {
            $query = "DELETE FROM menu WHERE id=?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            return false;
        }
    }
}

// Xử lý request
$menu = new MenuManager();
$method = $_SERVER['REQUEST_METHOD'];

if (
    ($method === 'POST' && isset($_POST['action'])) ||
    ($method === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_menu')
) {
    $action = $method === 'POST' ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'update_trangthai':
            if ($method !== 'POST') {
                echo json_encode(['error' => 'Phải dùng POST để cập nhật trạng thái']);
                exit;
            }
            $id = $_POST['id'] ?? null;
            $trangthai = $_POST['trangthai'] ?? null;
            if (!$id || !$trangthai) {
                echo json_encode(['error' => 'Thiếu dữ liệu']);
                exit;
            }
            $query = "UPDATE menu SET trangthai=? WHERE id=?";
            $stmt = $menu->db->prepare($query);
            $success = $stmt->execute([$trangthai, $id]);
            echo json_encode(['success' => $success]);
            break;

        case 'get_menu':
            $result = $menu->getAllMenu();
            echo json_encode($result);
            break;

        case 'add_menu':
            if ($method !== 'POST') {
                echo json_encode(['error' => 'Phải dùng POST để thêm món']);
                exit;
            }

            $tenmon = $_POST['tenmon'] ?? '';
            $gia = intval($_POST['gia'] ?? 0);
            $danhmucmon = $_POST['danhmucmon'] ?? '';
            $ghichu = $_POST['ghichu'] ?? '';
            $trangthai = $_POST['trangthai'] ?? 'Còn hàng';
            $hinhanh = '';

            if ($gia < 1000) {
                echo json_encode(['success' => false, 'error' => 'Giá phải ≥ 1000']);
                exit;
            }

            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === 0) {
                $uploadDir = __DIR__ . '/../img/';
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['hinhanh']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $targetPath)) {
                    $hinhanh = $fileName;
                }
            }

            $success = $menu->addMenu($tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai);
            echo json_encode(['success' => $success]);
            break;

        case 'update_menu':
            if ($method !== 'POST') {
                echo json_encode(['error' => 'Phải dùng POST để cập nhật món']);
                exit;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                echo json_encode(['error' => 'Thiếu ID']);
                exit;
            }

            $tenmon = $_POST['tenmon'] ?? '';
            $gia = intval($_POST['gia'] ?? 0);
            $danhmucmon = $_POST['danhmucmon'] ?? '';
            $ghichu = $_POST['ghichu'] ?? '';
            $trangthai = $_POST['trangthai'] ?? 'Còn hàng';
            $hinhanh = null;

            if ($gia < 1000) {
                echo json_encode(['success' => false, 'error' => 'Giá phải ≥ 1000']);
                exit;
            }

            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === 0) {
                $uploadDir = __DIR__ . '/../img/';
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['hinhanh']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $targetPath)) {
                    $hinhanh = $fileName;
                }
            }

            $success = $menu->updateMenu($id, $tenmon, $gia, $hinhanh, $danhmucmon, $ghichu, $trangthai);
            echo json_encode(['success' => $success]);
            break;

        case 'delete_menu':
            if ($method !== 'POST') {
                echo json_encode(['error' => 'Phải dùng POST để xóa món']);
                exit;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                echo json_encode(['error' => 'Thiếu ID']);
                exit;
            }

            $success = $menu->deleteMenu($id);
            echo json_encode(['success' => $success]);
            break;

        default:
            echo json_encode(['error' => 'Hành động không hợp lệ']);
    }
} else {
    echo json_encode(['error' => 'Request không hợp lệ: cần action']);
}
?>
