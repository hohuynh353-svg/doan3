<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quán Cơm Nhà</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/form_themnv.css">
    <link rel="stylesheet" href="../css/form_themmon.css">

<style>

    .hidden {
  display: none !important;
}

    .search-box {
  display: flex;
  align-items: center;
  border: 2px solid #ccc;
  border-radius: 25px;
  overflow: hidden;
  width: 250px;
  background-color: white;
}

.search-box input[type="text"] {
  border: none;
  outline: none;
  padding: 10px 15px;
  flex: 1;
  font-size: 14px;
  border-radius: 25px 0 0 25px;
}

.search-box button {
  border: none;
  background-color: #28a745; /* màu nút */
  color: white;
  padding: 10px 15px;
  cursor: pointer;
  border-radius: 0 25px 25px 0;
  transition: background-color 0.3s ease;
}

.search-box button:hover {
  background-color:rgb(19, 111, 24);
}

.search-box i {
  font-size: 16px;
}

#searchTour::placeholder {
  font-style: italic;
}

.menu-item a,
.menu-item a:visited {
  color: white !important;
  text-decoration: none;
}

.menu-item {
  list-style: none;
}

.modal.show {
  display: flex; /* Khi có class show sẽ hiện */
}

.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}
.btn-success {
    background-color: #28a745;
    color: white;
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}

</style>

</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>
            <img src="img/logo.png">
            Quán Cơm Nhà
        </h2>

        <button class="menu-item active" data-section="orders">
            <i class="fas fa-shopping-cart"></i>Quản Lý Đơn Hàng
        </button>
        <button class="menu-item" data-section="customers">
            <i class="fas fa-users"></i>Quản Lý Khách Hàng
        </button>
        <button class="menu-item" data-section="menu">
            <i class="fas fa-utensils"></i>Quản Lý Món Ăn
        </button>
        <button class="menu-item" data-section="staff">
            <i class="fa-solid fa-clipboard-user"></i>Quản Lý Tài Khoản
        </button>
        <button class="menu-item" data-section="employees">
            <i class="fas fa-user-tie"></i>Quản Lý Nhân Viên
        </button>
        <button class="menu-item" data-section="review">
            <i class="fas fa-user-tie"></i>Quản Lý Đánh Giá
        </button>
        <button class="menu-item" data-section="lienhe">
            <i class="fas fa-user-tie"></i>Quản Lý Liên Hệ
        </button>
        <button class="menu-item" data-section="thongke">
            <i class="fas fa-user-tie"></i>Thống Kê
        </button>
        <button class="menu-item" onclick="location.href='index.php'">
            <i class="fas fa-sign-out-alt"></i> Trang chủ
        </button>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 id="page-title">Trang Quản Trị</h1>
            <a href="dangxuat.php" class="btn btn-danger">Đăng Xuất</a>
        </div>

        <div class="content-area">
            <!-- Orders Section -->
            <div id="orders-section" class="section">
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Danh Sách Đơn Hàng</h2>
    <div class="search-box">
      <input type="text" placeholder="Tìm kiếm" />
      <button><i class="fas fa-search"></i></button>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Mã Đơn</th>
        <th>Khách Hàng</th>
        <th>Tên Món</th>
        <th>Số Lượng Món</th>
        <th>Ngày Đặt</th>
        <th>Tổng Tiền</th>
        <th>Trạng Thái</th>
        <th>Thao Tác</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#001</td>
        <td>Nguyễn Văn A</td>
        <td>150,000 VNĐ</td>
        <td>2</td>
        <td>2024-06-10</td>
        <td>300,000 VNĐ</td>
        <td>Đang xử lý</td>
        <td>
          <button class="btn btn-success">Sửa</button>
          <button class="btn btn-danger">Xóa</button>
        </td>
      </tr>
      <!-- Thêm các dòng khác nếu cần -->
    </tbody>
  </table>
</div>


            <!-- Customers Section -->
            <div id="customers-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Khách Hàng</h2>
                    <div style="display: flex; gap: 10px; align-items: center;">
        <div class="search-box">
            
    <input type="text" id="customer-search-input" placeholder="Tìm kiếm" oninput="checkIfCleared()" />
    <button onclick="filterCustomers()">
        <i class="fas fa-search"></i>
    </button>

            <button><i class="fas fa-search"></i></button>
        </div>
        <button class="btn btn-primary" onclick="openAddCustomerModal()">
            <i class="fas fa-plus"></i> Thêm Khách Hàng
        </button>
    </div>
                </div>

                <div id="customers-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="customers-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Điểm Tích Lũy</th>
                                <th>Ngày Tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="customers-tbody">
                            <!-- Data will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Menu Section -->
            <div id="menu-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Món Ăn</h2>
                    <button class="btn btn-primary" onclick="openMenuModal()">
                         <i class="fas fa-plus"></i> Thêm món mới
                    </button>

                </div>

                <div id="menu-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="menu-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên món</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Hình ảnh</th>
                                <th>Ngày Tạo</th>
                                <th>Ghi chú</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-menu">
                            <!-- Dữ liệu nhân viên sẽ được tải qua JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Section -->
            <div id="staff-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Tài Khoản</h2>
                    <button class="btn btn-primary" onclick="openAddStaffModal()">
                        <i class="fas fa-plus"></i> Tạo tài khoản
                    </button>
                </div>

                <div id="staff-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="staff-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Ngày Tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="staff-tbody">
                            <!-- Dữ liệu nhân viên sẽ được tải qua JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Employees Section -->
            <div id="employees-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Nhân Viên</h2>
                    <button class="btn btn-primary" onclick="openEmployeesModal()">
                         <i class="fas fa-plus"></i> Thêm nhân viên mới 
                    </button>

                </div>

                <div id="employees-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="employees-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Địa chỉ</th>
                                <th>Chức Vụ</th> <!-- Thêm cột Chức vụ -->
                                <th>Giới Tính</th>
                                <th>Ngày Tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-nhanvien">
                            <!-- Dữ liệu nhân viên sẽ được tải qua JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Review Section -->
            <div id="review-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Đánh Giá</h2>
                    <div class="search-box">
              <input
    type="text"
    id="review-search-input"
    placeholder="Tìm kiếm"
    oninput="checkIfReviewCleared()"
  />
  <button onclick="filterReviews()">
    <i class="fas fa-search"></i>
  </button>
            </div>
                </div>

                <div id="review-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="review-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên Khách Hàng</th>
                                <th>Nội Dung Đánh Giá</th>
                                <th>Số Sao Đánh Giá</th>
                                <th>Ngày Đánh Giá</th> <!-- Thêm cột Chức vụ -->
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="review-tbody">
                            <?php include 'load_danhgia.php'; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- LienHe Section -->
            <div id="lienhe-section" class="section hidden">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Danh Sách Liên Hệ</h2>
                    <div class="search-box">
              <input
    type="text"
    id="lienhe-search-input"
    placeholder="Tìm kiếm"
    oninput="checkIfLienHeCleared()"
  />
  <button onclick="filterLienHe()">
    <i class="fas fa-search"></i>
  </button>
            </div>

                </div>

                <div id="lienhe-loading" class="loading hidden">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải...
                </div>

                <div class="table-container">
                    <table id="lienhe-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên Khách Hàng</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Nội Dung Liên Hệ</th>
                                <th>Ngày Liên Hệ</th> <!-- Thêm cột Chức vụ -->
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="lienhe-tbody">
  <?php include 'quanly_lienhe.php'; ?>
</tbody>
                    </table>
                </div>
            </div>

        </div> <!-- End content-area -->
    </div> <!-- End main-content -->
</div> <!-- End container -->

<!-- Modals -->

<!-- Customer Modal -->
<div id="customerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCustomerModal()">&times;</span>
        <h3 id="modal-title">Thêm Khách Hàng Mới</h3>
        <form id="customerForm">
            <input type="hidden" id="customer-id">

            <div class="form-group">
                <label for="customer-hoten">Họ Tên:</label>
                <input type="text" id="customer-hoten" name="hoten" required>
            </div>

            <div class="form-group">
                <label for="customer-email">Email:</label>
                <input type="email" id="customer-email" name="email" required>
            </div>

            <div class="form-group">
                <label for="customer-sdt">Số Điện Thoại:</label>
                <input type="text" id="customer-sdt" name="sdt" required>
            </div>

            <div class="form-group" id="password-group">
                <label for="customer-matkhau">Mật Khẩu:</label>
                <input type="password" id="customer-matkhau" name="matkhau" required>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn" onclick="closeCustomerModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<!-- Staff Modal -->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeStaffModal()">&times;</span>
        <h3 id="staff-modal-title"> Nhân Viên </h3>
        <form id="staffForm"  >
            <input type="hidden" id="staff-id">

            <div class="form-group">
                <label for="hoten">Họ Tên:</label>
                <input type="text" id="hoten" name="hoten" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="sdt">Số Điện Thoại:</label>
                <input type="text" id="sdt" name="sdt" required>
            </div>

            <div class="form-group" id="staff-password-group">
                <label for="matkhau">Mật Khẩu:</label>
                <input type="password" id="matkhau" name="matkhau" required>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn" onclick="closeStaffModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<!-- Employees Modal -->
<div id="employeesModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEmployeesModal()">&times;</span>
    <h3 id="employees-modal-title">Thêm Nhân Viên Mới</h3>
    <form id="employeesForm" >
      <input type="hidden" id="employees-id" />

      <div class="form-group">
        <div class="form-field">
          <label class="required">Họ và tên</label>
          <input type="text" name="tennv" placeholder="Nhập họ và tên nhân viên" required/>
        </div>

        <div class="form-field">
          <label class="required">Email</label>
          <input type="text" name="email" placeholder="Nhập email" required/>
        </div>

        <div class="form-field">
          <label class="required">Số điện thoại</label>
          <input type="text" name="sdt" placeholder="Nhập số điện thoại" required/>
        </div>

        <div class="form-field">
          <label class="required">Địa chỉ</label>
          <input type="text" name="diachi" placeholder="Nhập địa chỉ" required/>
        </div>

        <div class="form-field">
          <label class="required">Chức vụ</label>
          <select name="chucvu">
            <option>Đầu bếp</option>
            <option>Phụ bếp</option>
            <option>Giao hàng</option>
          </select>
        </div>

        <div class="form-field">
          <label class="required">Giới tính</label>
          <select name="gioitinh">
            <option>Nam</option>
            <option>Nữ</option>
            <option>Khác</option>
          </select>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-cancel" onclick="closeEmployeesModal()">Huỷ</button>
          <button type="submit" class="btn btn-submit">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Menu Modal -->
<div id="menu" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeMenuModal()">&times;</span>
    <h3 id="menu-modal-title">Thêm Món Mới</h3>
      <form>
        <div class="form-group">
          <div class="form-field">
            <label class="required">Tên Món</label>
            <input type="text" placeholder="Nhập tên món ăn" required/>
          </div>

          <div class="form-field">
            <label class="required">Số lượng</label>
            <input type="text" placeholder="Nhập số lượng"required/>
          </div>

          <div class="form-field">
            <label class="required">Giá</label>
            <input type="text" placeholder="Nhập giá"required/>
          </div>

          <div class="form-field">
            <label class="required">Hình ảnh</label>
            <input type="file" accept="image/*"required/>
          </div>

          <div class="form-field">
            <label class="required">Danh mục</label>
            <select>
              <option>Cơm</option>
              <option>Mì-Hủ tiếu-Bún</option>
              <option>Món Kho</option>
              <option>Món Canh</option>
              <option>Món Chay</option>
            </select>
          </div>

          <div class="form-field" style="flex: 1 1 100%">
            <label class="required">Ghi chú</label>
            <textarea
              placeholder="Nhập ghi chú..."
              rows="4"
              style="resize: vertical"
            ></textarea>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-cancel" onclick="closeMenuModal()">Huỷ</button>
            <button type="submit" class="btn btn-submit">Thêm</button>
          </div>
        </div>
      </form>
  </div>
</div>



    <script>
        // Navigation handling
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('.section').forEach(section => section.classList.add('hidden'));
                
                // Show selected section
                const sectionName = this.getAttribute('data-section');
                const section = document.getElementById(sectionName + '-section');
                if (section) {
                    section.classList.remove('hidden');
                    
                    // Update page title
                    const titles = {
                        'orders': 'Quản Lý Đơn Hàng',
                        'customers': 'Quản Lý Khách Hàng',
                        'menu': 'Quản Lý Món Ăn',
                        'staff': 'Quản Lý Tài Khoản',
                        'employees': 'Quản Lý Nhân Viên',
                        'review': 'Quản Lý Đánh Giá',
                        'lienhe': 'Quản Lý Liên Hệ'
                    };
                    document.getElementById('page-title').textContent = titles[sectionName];
                    
                    // Load customers data when customers section is selected
                    if (sectionName === 'customers') {
                        loadCustomers();
                    }
                }
            });
        });
        //////////
        function openAddStaffModal() {
    document.getElementById('staffForm').reset();
    document.getElementById('staff-id').value = '';
    document.getElementById('staff-modal-title').innerText = 'Tạo tài khoản Nhân Viên';
    document.getElementById('staffModal').style.display = 'block';
       }




function closeStaffModal() {
    document.getElementById('staffModal').style.display = 'none';
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('staffModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
////
function openEmployeesModal() {
  console.log("Đã gọi openEmployeesModal");
  const modal = document.getElementById('employeesModal');
  modal.classList.remove('hidden');}

/////////
      
    </script>
    
       <script src="../js/taikhoannv.js"></script>
       <script src="../js/danhsachKH.js"></script>
       <script src="../js/danhsachnv.js"></script>

    

  <script>
  // Đóng modal
  function closeEmployeesModal() {
    document.getElementById('employeesModal').style.display = 'none';
  }

  // Load lại danh sách nhân viên
  function loadNhanVien() {
    fetch("load_nv.php")
      .then(response => response.text())
      .then(data => {
        document.getElementById("table-body-nhanvien").innerHTML = data;
      });
  }

  // Xử lý thêm nhân viên bằng AJAX
  document.getElementById("employeesForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Ngăn submit truyền thống

    const formData = new FormData(this);

    fetch("quanlynv.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      if (data.trim() === "success") {
        alert("Đã thêm nhân viên!");

        // ✅ Đóng modal
        closeEmployeesModal();

        // ✅ Reset form
        this.reset();

        // ✅ Cập nhật bảng ngay lập tức
        loadNhanVien();
      } else {
        alert("Lỗi khi thêm nhân viên: " + data);
      }
    });
  });

  // Tự động load bảng khi vào trang
  document.addEventListener("DOMContentLoaded", loadNhanVien);
</script>

<!-- Mở modal thêm món-->
<script>
  function openMenuModal() {
    document.getElementById("menu").style.display = "block";
  }
</script>

<!-- Đóng modal thêm món-->
<script>
  function openMenuModal() {
    const modal = document.getElementById("menu");
    if (modal) {
      modal.style.display = "block";
    }
  }
</script>

<script>
  function closeMenuModal() {
    const modal = document.getElementById("menu");
    if (modal) {
      modal.style.display = "none";
    }
  }
</script>

<!--load liên hệ-->
<script>
  document.getElementById("menu-lienhe").addEventListener("click", function () {
  document.getElementById("lienhe-section").classList.remove("hidden");
  loadLienHe();
});

</script> 

<!--load đánh giá-->
<script>
  document.getElementById("menu-review").addEventListener("click", function () {
  document.getElementById("review-section").classList.remove("hidden");
  loadLienHe();
});
</script>

<!--tìm kiếm khách hàng-->
<script>
function filterCustomers() {
    const input = document.getElementById("customer-search-input");
    const filter = input.value.toLowerCase().trim();
    const rows = document.querySelectorAll("#customers-tbody tr");

    rows.forEach(row => {
        const rowText = row.innerText.toLowerCase();
        row.style.display = rowText.includes(filter) ? "" : "none";
    });
}

function checkIfCleared() {
    const input = document.getElementById("customer-search-input");
    const filter = input.value.toLowerCase().trim();

    if (filter === "") {
        // Nếu ô tìm kiếm bị xóa sạch → hiển thị lại toàn bộ danh sách
        const rows = document.querySelectorAll("#customers-tbody tr");
        rows.forEach(row => {
            row.style.display = "";
        });
    }
}
</script>

<!--tìm kiếm đánh giá-->
<script>
function filterReviews() {
  const input = document.getElementById("review-search-input");
  const filter = input.value.toLowerCase().trim();
  const rows = document.querySelectorAll("#review-tbody tr");

  rows.forEach(row => {
    const rowText = row.innerText.toLowerCase();
    row.style.display = rowText.includes(filter) ? "" : "none";
  });
}

function checkIfReviewCleared() {
  const input = document.getElementById("review-search-input");
  const filter = input.value.toLowerCase().trim();

  // Nếu người dùng xóa hết nội dung tìm kiếm → hiện lại toàn bộ
  if (filter === "") {
    const rows = document.querySelectorAll("#review-tbody tr");
    rows.forEach(row => {
      row.style.display = "";
    });
  }
}
</script>

<!--tìm kiếm liên hệ-->
<script>
function filterLienHe() {
  const input = document.getElementById("lienhe-search-input");
  const filter = input.value.toLowerCase().trim();
  const rows = document.querySelectorAll("#lienhe-tbody tr");

  rows.forEach(row => {
    const rowText = row.innerText.toLowerCase();
    row.style.display = rowText.includes(filter) ? "" : "none";
  });
}

function checkIfLienHeCleared() {
  const input = document.getElementById("lienhe-search-input");
  const filter = input.value.toLowerCase().trim();

  if (filter === "") {
    const rows = document.querySelectorAll("#lienhe-tbody tr");
    rows.forEach(row => {
      row.style.display = "";
    });
  }
}
</script>




</body>
</html>