<?php
// database.php - Kết nối cơ sở dữ liệu
class Database {
    private $host = 'localhost';
    private $db_name = 'restaurant_menu';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Lỗi kết nối: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// menu.php - Class quản lý menu
class Menu {
    private $conn;
    private $table_name = "menu_items";

    public $id;
    public $name;
    public $category;
    public $price;
    public $description;
    public $image;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả món ăn
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy món ăn theo category
    public function readByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category);
        $stmt->execute();
        return $stmt;
    }

    // Tìm kiếm món ăn
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE name LIKE ? OR description LIKE ? 
                 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);
        $stmt->execute();
        return $stmt;
    }

    // Thêm món ăn mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET name=:name, category=:category, price=:price, 
                    description=:description, image=:image, status=:status";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind dữ liệu
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lấy thông tin một món ăn
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->name = $row['name'];
            $this->category = $row['category'];
            $this->price = $row['price'];
            $this->description = $row['description'];
            $this->image = $row['image'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Cập nhật món ăn
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET name = :name, category = :category, price = :price,
                    description = :description, image = :image, status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa món ăn
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// index.php - Trang chính hiển thị danh sách menu
session_start();
require_once 'database.php';
require_once 'menu.php';

$database = new Database();
$db = $database->getConnection();
$menu = new Menu($db);

// Xử lý tìm kiếm và lọc
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($search)) {
    $stmt = $menu->search($search);
} elseif (!empty($category_filter)) {
    $stmt = $menu->readByCategory($category_filter);
} else {
    $stmt = $menu->readAll();
}

$categories = [
    'com-tam' => 'Cơm tấm',
    'com-ga' => 'Cơm gà',
    'com-chien' => 'Cơm chiên',
    'bun-pho' => 'Bún - Phở',
    'mon-ca-ri' => 'Món cà ri',
    'mon-chay' => 'Món chay',
    'do-uong' => 'Đồ uống'
];

function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

function getStatusBadge($status) {
    $badges = [
        'available' => '<span class="badge bg-success">Còn hàng</span>',
        'out-of-stock' => '<span class="badge bg-danger">Hết hàng</span>',
        'discontinued' => '<span class="badge bg-secondary">Ngừng bán</span>'
    ];
    return $badges[$status] ?? $badges['available'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Menu - Quán Cơm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .menu-card {
            transition: transform 0.2s;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .btn-group-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .menu-card:hover .btn-group-actions {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-utensils me-2"></i>Quản lý Menu</a>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Header với nút thêm và tìm kiếm -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-list me-2"></i>Danh sách Menu</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="add_menu.php" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Thêm món mới
                </a>
            </div>
        </div>

        <!-- Thanh tìm kiếm và lọc -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" 
                                       value="<?php echo htmlspecialchars($search); ?>" 
                                       placeholder="Tìm kiếm món ăn...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                <?php foreach($categories as $key => $value): ?>
                                    <option value="<?php echo $key; ?>" 
                                            <?php echo ($category_filter == $key) ? 'selected' : ''; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i>Lọc
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thông báo -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <!-- Danh sách menu -->
        <div class="row">
            <?php
            $num = $stmt->rowCount();
            if($num > 0):
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    extract($row);
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card menu-card h-100 position-relative">
                        <div class="btn-group-actions">
                            <a href="edit_menu.php?id=<?php echo $id; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_menu.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa món này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                        
                        <?php if(!empty($image)): ?>
                            <img src="<?php echo $image; ?>" class="card-img-top" alt="<?php echo $name; ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image text-muted fa-3x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $name; ?></h5>
                            <p class="card-text flex-grow-1"><?php echo $description; ?></p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-info"><?php echo $categories[$category] ?? $category; ?></span>
                                    <?php echo getStatusBadge($status); ?>
                                </div>
                                <div class="h5 text-primary mb-0">
                                    <?php echo formatCurrency($price); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
            ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Không tìm thấy món ăn nào.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// add_menu.php - Trang thêm món ăn mới
session_start();
require_once 'database.php';
require_once 'menu.php';

$database = new Database();
$db = $database->getConnection();
$menu = new Menu($db);

if($_POST) {
    $menu->name = $_POST['name'];
    $menu->category = $_POST['category'];
    $menu->price = $_POST['price'];
    $menu->description = $_POST['description'];
    $menu->image = $_POST['image'];
    $menu->status = $_POST['status'];

    if($menu->create()) {
        $_SESSION['message'] = "Món ăn đã được thêm thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Có lỗi xảy ra khi thêm món ăn.";
    }
}

$categories = [
    'com-tam' => 'Cơm tấm',
    'com-ga' => 'Cơm gà', 
    'com-chien' => 'Cơm chiên',
    'bun-pho' => 'Bún - Phở',
    'mon-ca-ri' => 'Món cà ri',
    'mon-chay' => 'Món chay',
    'do-uong' => 'Đồ uống'
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm món mới - Quản lý Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-utensils me-2"></i>Quản lý Menu</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-plus me-2"></i>Thêm món ăn mới</h4>
                    </div>
                    <div class="card-body">
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên món ăn <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select" id="category" name="category" required>
                                            <?php foreach($categories as $key => $value): ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="price" name="price" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="available">Còn hàng</option>
                                            <option value="out-of-stock">Hết hàng</option>
                                            <option value="discontinued">Ngừng bán</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">URL Hình ảnh</label>
                                <input type="url" class="form-control" id="image" name="image" 
                                       placeholder="https://example.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả món ăn</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu món ăn
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// edit_menu.php - Trang chỉnh sửa món ăn
session_start();
require_once 'database.php';
require_once 'menu.php';

$database = new Database();
$db = $database->getConnection();
$menu = new Menu($db);

// Lấy ID từ URL
$id = isset($_GET['id']) ? $_GET['id'] : die('ID không hợp lệ.');

$menu->id = $id;
if(!$menu->readOne()) {
    $_SESSION['message'] = "Không tìm thấy món ăn.";
    $_SESSION['message_type'] = "danger";
    header("Location: index.php");
    exit();
}

if($_POST) {
    $menu->name = $_POST['name'];
    $menu->category = $_POST['category'];
    $menu->price = $_POST['price'];
    $menu->description = $_POST['description'];
    $menu->image = $_POST['image'];
    $menu->status = $_POST['status'];

    if($menu->update()) {
        $_SESSION['message'] = "Món ăn đã được cập nhật thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật món ăn.";
    }
}

$categories = [
    'com-tam' => 'Cơm tấm',
    'com-ga' => 'Cơm gà',
    'com-chien' => 'Cơm chiên', 
    'bun-pho' => 'Bún - Phở',
    'mon-ca-ri' => 'Món cà ri',
    'mon-chay' => 'Món chay',
    'do-uong' => 'Đồ uống'
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa món ăn - Quản lý Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-utensils me-2"></i>Quản lý Menu</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-edit me-2"></i>Chỉnh sửa món ăn</h4>
                    </div>
                    <div class="card-body">
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên món ăn <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($menu->name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select" id="category" name="category" required>
                                            <?php foreach($categories as $key => $value): ?>
                                                <option value="<?php echo $key; ?>" 
                                                        <?php echo ($menu->category == $key) ? 'selected' : ''; ?>>
                                                    <?php echo $value; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="price" name="price" min="0" 
                                               value="<?php echo $menu->price; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="available" <?php echo ($menu->status == 'available') ? 'selected' : ''; ?>>
                                                Còn hàng
                                            </option>
                                            <option value="out-of-stock" <?php echo ($menu->status == 'out-of-stock') ? 'selected' : ''; ?>>
                                                Hết hàng
                                            </option>
                                            <option value="discontinued" <?php echo ($menu->status == 'discontinued') ? 'selected' : ''; ?>>
                                                Ngừng bán
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">URL Hình ảnh</label>
                                <input type="url" class="form-control" id="image" name="image" 
                                       value="<?php echo htmlspecialchars($menu->image); ?>"
                                       placeholder="https://example.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả món ăn</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($menu->description); ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Cập nhật món ăn
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// delete_menu.php - Xóa món ăn
session_start();
require_once 'database.php';
require_once 'menu.php';

if(isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $menu = new Menu($db);
    
    $menu->id = $_GET['id'];
    
    if($menu->delete()) {
        $_SESSION['message'] = "Món ăn đã được xóa thành công!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra khi xóa món ăn.";
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "ID không hợp lệ.";
    $_SESSION['message_type'] = "danger";
}

header("Location: index.php");
exit();
?>

<?php
// create_database.sql - Script tạo database và bảng