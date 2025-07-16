


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" >
    <title> Cơm Nhà </title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
 
<style>
    .carousel-item img {
        image-rendering: crisp-edges;
        filter: contrast(110%) brightness(105%);
        -webkit-optimize-contrast: 2;
    }

    .logout-button {
    text-decoration: none; /* Bỏ gạch dưới */
    color: black; 
    }

    .logout-button:hover {
    color: red;
    text-decoration: none; /* vẫn không có gạch dưới khi hover */

    
}
</style>
</head>
<body>

   <div class="header-bar">
        <div class="container">
            <div class="header-content">
                <!-- Left: Location -->
                <div class="header-left">
                    <div class="location-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa chỉ: 162/1, Đường 3/2, Ninh Kiều, Cần Thơ</span>
                    </div>
                </div>

                
                <div class="box-center" style="font-weight: bold;">
                    <?php
                        session_start();
                        if (!isset($_SESSION['hoten'])) {
                            echo '<a href="dangki.php">Đăng ký</a> | <a href="dangnhap.php">Đăng nhập</a>';
                        } else {
                            echo '<span class="welcome-message">Xin Chào:  ' . htmlspecialchars($_SESSION['hoten']) . '</span>';
                            echo ' | <a href="dangxuat.php" class="logout-button">Đăng xuất</a>'; 
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                echo ' | <a href="admin.php" class="logout-button"> Quản Trị</a>';
                            }
                        }
                    ?>
                </div>

                <!-- Right: Contact Info -->
                <div class="header-right">
                    <div class="contact-info">
                        <div class="contact-item">
                            <span>Hotline:</span>
                            <a href="tel:0879342732">0879 342 732</a>
                        </div>
                        <span class="divider">|</span>
                        <div class="contact-item">
                            <span>Email:</span>
                            <a href="mailto:hohuynh@gmail.com">comnha@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<nav class="small navbar navbar-expand-lg border-bottom sticky-top">
  <div class="container position-relative">
    
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <img src="../img2/logo.png" alt="Bootstrap" />
    </a>

    <!-- Nút mở menu khi thu nhỏ -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nội dung navbar -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <!-- Menu chính -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Trang Chủ</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown"
             aria-expanded="false">
            Thực Đơn 
          </a>
          <ul class="dropdown-menu">
  <li><a class="dropdown-item" href="index.php?madanhmuc=1">🍚 Cơm</a></li>
  <li><a class="dropdown-item" href="index.php?madanhmuc=2">🍜 Mì – Hủ tiếu – Bún</a></li>
  <li><a class="dropdown-item" href="index.php?madanhmuc=3">🍛 Món Kho</a></li>
  <li><a class="dropdown-item" href="index.php?madanhmuc=4">🍲 Món Canh</a></li>
  <li><a class="dropdown-item" href="index.php?madanhmuc=5">🥬 Món Chay</a></li>
</ul>

        </li>

        <li class="nav-item">
          <a class="nav-link active fw-bold" href="index.php">Đặt Món</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
             aria-expanded="false">
            Giới Thiệu
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="vechungtoi.php">Về chúng tôi</a></li>
            <li><a class="dropdown-item" href="chinhsachnguoisohuu.php">Chính sách</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="lienhe.php">Liên Hệ</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="trang_danhgia.php">Đánh giá</a>
        </li>
      </ul>

      <!-- Thanh tìm kiếm + nút ưu đãi (căn phải) -->
      
        
        <!-- Thanh tìm kiếm -->
        <div class="search-bar">
          <input type="text" class="search-input" placeholder="Tìm kiếm...">
          <button class="search-btn">
            <i class="fas fa-search"></i>
          </button>
        </div>

        
      

    </div> <!-- kết thúc .navbar-collapse -->

  </div> <!-- kết thúc .container -->
  <!-- Nút đăng ký -->
<div class="btn-wrapper flash-btn-fixed">
  <?php if (!isset($_SESSION['user_id'])): ?>
    <!-- Chưa đăng nhập: Hiện nút đăng ký -->
    <a href="dangki.php" class="flash-btn" style="display: inline-block; text-align: center; text-decoration: none;">
      🎁 ĐĂNG KÝ NHẬN ƯU ĐÃI<br>
    </a>
  <?php else: ?>
    <!-- Đã đăng nhập: Hiện tên người dùng -->
    <a href="taikhoannguoidung.php" class="flash-btn" style="display: inline-block; text-align: center; text-decoration: none;">
      👤 <?= htmlspecialchars($_SESSION['hoten']) ?>
    </a>
  <?php endif; ?>
</div>



</nav>

<!-- Font Awesome cho icon tìm kiếm -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   

    <header>
    <div class="container ">
        <div class="slider">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="../img2/banner1.png" class="d-block w-100" alt="Banner 2" />
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="../img2/banner2.png" class="d-block w-100" alt="Banner 3" />
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

   </header>
  


<section class="menu2-section">
  <h2 class="menu2-title">Lựa chọn thực đơn</h2>
  <div class="menu2-options">
    <div class="menu2-item">
      <img src="../img2/com7.png" alt="Cơm" />
      <p>🍚 Cơm</p>
    </div>
    <div class="menu2-item">
      <img src="../img2/bun1.png" alt="Mì – Hủ tiếu – Bún" />
      <p>🍜 Mì – Hủ tiếu – Bún</p>
    </div>
    <div class="menu2-item">
      <img src="../img2/monkho1.png" alt="Món Kho" />
      <p>🍛 Món Kho</p>
    </div>
    <div class="menu2-item">
      <img src="../img2/canh5.png" alt="Món Canh" />
      <p>🍲 Món Canh</p>
    </div>
    <div class="menu2-item">
      <img src="../img2/monchay4.png" alt="Món Chay" />
      <p>🥬 Món Chay</p>
    </div>
  </div>
</section>

<!-- Quảng cáo ưu đãi -->
<section class="promo-banner">
  <img src="../img2/dangki.png" alt="Ưu đãi tích điểm" />
</section>






<section class="services-section">
         <div style="height: 1px; background-color: #FF0000; margin-top: -30px;  margin-bottom: 20px;"></div>
  <h2 class="section-title">CUNG CẤP SUẤT ĂN VĂN PHÒNG & CÔNG NGHIỆP</h2>
  <div class="services-grid">
    <div class="service-card highlight">
      <img src="../img2/thucdon.png" alt="Thực đơn cơm" class="service-icon" />
      <h3>Thực đơn cơm văn phòng</h3>
      <p>Thực đơn cơm văn phòng được các đầu bếp có tay nghề, uyên thâm trong lĩnh vực cơm văn phòng chế biến</p>
      <a href="#" class="detail-link">Chi tiết</a>
    </div>

    <div class="service-card highlight">
      <img src="../img2/giaohang.png" alt="Giao cơm" class="service-icon" />
      <h3>Dịch vụ giao cơm tận nơi</h3>
      <p>Giao cơm tận nơi là trách nhiệm của chúng tôi, mọi ưu tiên về quyền lợi và sự hài lòng của khách hàng là tiêu chí của chúng tôi</p>
      <a href="dichvugiaocom.php" class="detail-link">Chi Tiết</a>
    </div>

    <div class="service-card highlight ">
      <img src="../img2/nguyenlieu.png" alt="Nguyên liệu tươi" class="service-icon" />
      <h3>Chất lượng nguyên liệu </h3>
      <p>Chất lượng nguyên liệu luôn luôn đứng đầu trong các lựa chọn để có một món ăn ngon miệng, sức khỏe</p>
      <a href="chatluongnguyenlieu.php" class="detail-link">Chi Tiết</a>
    </div>
  </div>
</section>
 <div style="height: 1px; background-color: #FF0000; margin-top: -30px;  margin-bottom: 20px;"></div>
<div id="menu-container"></div>

<!-- trangthaiquan -->
<div id="closedForm" class="closed-overlay" style="display:none;">
  <div class="closed-box">
    <div class="closed-icon">🔒</div>
    <h1>Quán Đã Đóng Cửa</h1>
    <p>Chúng tôi rất tiếc vì không thể phục vụ quý khách vào lúc này!</p>
    <p>Cơm Nhà sẽ trở lại với những món ăn tuyệt vời.</p>

    <div class="closed-hours">
      <p>🕒 <strong>Giờ Mở Cửa:</strong></p>
      <p>Thứ 2 - Chủ nhật: 8:00 - 21:00</p>
      <p>Nghỉ lễ: 8:00 - 15:00</p>
    </div>

    <div class="closed-info">
      <p><span class="emoji">📞</span>Liên hệ: 0879 342 732</p>
      <p><span class="emoji">📍</span>Địa chỉ: 162/1, Đường 3/2, Ninh Kiều, Cần Thơ</p>
    </div>
  </div>
</div>


   

  


    <footer class="text-bg-dark py-5">
      <div class="container">
        
        <div class="row">
          <div class="col-md-4">
            <div class="text-start mx-4 mb-2">
            <a class="navbar-brand" href="#">
                <img src="./img/logoshop.png" alt="Bootstrap" style="width: 150px; height: auto;" />
            </a>
              <p class="small text-start">
                Thương hiệu siêu thị uy tín và chất lượng, cam kết mang đến
                những trải nghiệm mua sắm tiện lợi, hiện đại và phong phú.
              </p>
              <div class="small text-start">
                <i class="fa-solid fa-location-dot"></i> Địa chỉ: Đồng Văn Cống, An Thới, Bình Thủy, Cần Thơ.
              </div>
              <div class="small text-start">
                <i class="fa-solid fa-phone-volume"></i> Hotline: 09876340987634
              </div>
              <div class="small text-start">
                <i class="fa-solid fa-envelope"></i> Email: ho353huynh@gmail.com
              </div>
            </div>
          </div>
          <div class="small col-md-2">
            <h6>Hỗ trợ khách hàng</h6>
            <ul class="mb-2">
              <li>
                <a class="text-decoration-none text-light" href="lienhe.php"
                  >Liên hệ </a
                >
              </li>
              <li>
                <a class="text-decoration-none text-light" href=""
                  >Hệ thống cửa hàng</a
                >
              </li>
              <li>
                <a class="text-decoration-none text-light" href="">Tìm kiếm</a>
              </li>
              <li>
                <a class="text-decoration-none text-light" href=""
                  >Giới thiệu</a
                >
              </li>
            
            </ul>
          </div>
          <div class="small col-md-3">
            <h6>Chính sách</h6>
            <ul>
              <li>
                <a class="text-decoration-none text-light" href="chinhsachnguoisohuu.php"
                  >Chính sách người sở hữu</a
                >
              </li>
              <li>
                <a class="text-decoration-none text-light" href="chinnhsachdoitra.php"
                  >Chính sách đổi trả </a
                >
              </li>
              <li>
                <a class="text-decoration-none text-light" href="chinnhsachthanhtoan.php"
                  >Chính sách thanh toán </a
                >
              </li>
            </ul>
            
            <h6>Tổng đài hỗ trợ</h6>
            <ul>
              <li>
                <a class="text-decoration-none text-light" href=""
                  >Gọi mua hàng: 19006750 (8h-20h)</a
                >
              </li>
              <li>
                <a class="text-decoration-none text-light" href=""
                  >Gọi bảo hành: 19006750 (8h-20h)</a
                >
              </li>
            </ul>
          </div>
          <div class="col-md-3 footer">
          
            <h6>MẠNG XÃ HỘI</h6>
            <div class="d-flex flex-column gap-2">
              <a
                href="#!"
                class="btn btn-primary mb-2 px-2 py-1 rounded-pill d-inline-flex align-items-center justify-content-center"
                style="width: 160px; font-size: 0.85rem"
              >
                <i class="fa-brands fa-facebook me-1"></i>
                <span>Facebook</span>
              </a>
            </div>

            <div>
              <a
                href="#!"
                class="btn btn-danger px-2 py-1 rounded-pill d-inline-flex align-items-center justify-content-center"
                style="width: 160px; font-size: 0.85rem"
              >
                <i class="fa-brands fa-youtube me-1"></i>
                <span>Youtube</span>
              </a>
            </div>
          </div>
        </div>
       </div>
      <div class="map">
            <iframe
              width="100%"
              height="100%"
              style="border: 0"
              loading="lazy"
              allowfullscreen
              referrerpolicy="no-referrer-when-downgrade"
 src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.007!2d105.7817961!3d10.0302531!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDE4JzEwLjkiTiAxMDXCsDQ2JzU0LjUiRQ!5e0!3m2!1svi!2s!4v1623456789!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">            >
            </iframe>
     </div>
    </footer>
    <div class="container-fluid bg-black text-white text-center p-2">
      © Bản quyền thuộc về EGANY | Cung cấp bởi Haravan
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<script>
fetch("get_menu.php")
  .then((res) => res.json())
  .then((data) => {
    const container = document.getElementById("menu-container");
    container.innerHTML = ""; // Xóa cũ nếu có

    for (const danhmucId in data) {
      const danhMuc = data[danhmucId];
      const tenDanhMuc = danhMuc.tendanhmuc || `Danh mục ${danhmucId}`;
      const group = danhMuc.monan;

      // Tạo khối danh mục
      const section = document.createElement("section");
      section.className = "menu-section";
      section.innerHTML = `<h2>${tenDanhMuc}</h2>`;

      const monList = document.createElement("div");
      monList.className = "menu-list"; // dùng grid ở đây

      group.forEach((mon) => {
        const rating = parseFloat(mon.sao) || 4.5;
        const fullStars = Math.floor(rating);
        const halfStar = rating % 1 >= 0.5;
        let starHtml = "";

        for (let i = 0; i < fullStars; i++) starHtml += "⭐";
        if (halfStar) starHtml += "✩";

        const isHot = mon.hot === "1" || mon.tenmon.toLowerCase().includes("đặc biệt");

        // Tạo thẻ <a> bọc toàn bộ item
        const link = document.createElement("a");
        link.href = `chitietsanpham.php?id=${mon.id}`;
        link.style.textDecoration = "none";
        link.style.color = "inherit";

        // Tạo div item bên trong <a>
        const item = document.createElement("div");
        item.className = "mon-item";
        item.innerHTML = `
          ${isHot ? `<div class="hot-label">🔥 HOT</div>` : ""}
          <img src="../img/${mon.hinhanh}" alt="${mon.tenmon}">
          <h3>${mon.tenmon}</h3>
          <div class="price">Giá: ${Number(mon.gia).toLocaleString("vi-VN")}đ</div>
          <div class="note">${mon.ghichu || ""}</div>
          <div class="rating">${starHtml} <span style="color:#aaa">(${rating}/5)</span></div>
          <button class="order-btn">ĐẶT NGAY</button>
        `;

        // Thêm div vào trong <a>
        link.appendChild(item);

        // Thêm <a> vào danh sách món
        monList.appendChild(link);
      });

      section.appendChild(monList);
      container.appendChild(section);
    }
  })
  .catch((error) => {
    console.error("Lỗi khi tải menu:", error);
  });
</script>

<!-- trangthaiquan -->
<script>
  fetch('get-trangthai.php')
    .then(res => res.json())
    .then(data => {
      console.log("Trạng thái nhận được:", data.trangthai); // DEBUG
      if (data.trangthai === 'dong') {
        document.getElementById('closedForm').style.display = 'flex';
      }
    })
    .catch(err => console.error("Lỗi khi gọi get-trangthai.php:", err));
</script>




</body>

</html> 
