// menu.js - Script quản lý danh sách món ăn

function loadMenuItems() {
  fetch("../php/danhsachmonan.php?action=get_menu")
    .then((res) => res.json())
    .then((data) => displayMenuItems(data))
    .catch((err) => {
      console.error(err);
      alert("Lỗi khi tải danh sách món ăn");
    });
}

function displayMenuItems(menu) {
  const tbody = document.getElementById("menu-tbody");
  tbody.innerHTML = "";

  menu.forEach((item, i) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${i + 1}</td>
      <td>${item.tenmon}</td>
      <td>${Number(item.gia).toLocaleString("vi-VN")} đ</td>
      <td>
        ${
          item.hinhanh
            ? `<img src="../img/${item.hinhanh}" width="60">`
            : "Không có ảnh"
        }
      </td>
      <td>${item.tendanhmuc}</td>
      <td>${item.ghichu || ""}</td>
      <td>
        <select onchange="updateTrangThai(${item.id}, this.value)">
          <option value="Còn hàng" ${
            item.trangthai === "Còn hàng" ? "selected" : ""
          }>Còn hàng</option>
          <option value="Hết hàng" ${
            item.trangthai === "Hết hàng" ? "selected" : ""
          }>Hết hàng</option>
        </select>
      </td>
      <td>${item.ngaytao}</td>
      <td>
        <button class="btn btn-success" onclick="editMenuItem(
          ${item.id},
          '${escapeQuotes(item.tenmon)}',
          '${item.gia}',
          '${item.danhmucmon}',
          '${escapeQuotes(item.ghichu)}',
          '${item.hinhanh || ""}',
          '${item.trangthai || "Còn hàng"}'
        )">
          <i class="fas fa-edit"></i> Sửa
        </button>
        <button class="btn btn-danger" onclick="deleteMenuItem(${item.id})">
          <i class="fas fa-trash"></i> Xóa
        </button>
      </td>
    `;
    tbody.appendChild(row);
  });
}

function escapeQuotes(str) {
  return String(str || "").replace(/'/g, "\\'");
}

function openAddMenuModal() {
  document.getElementById("modal-title-menu").textContent = "Thêm Món Ăn Mới";
  document.getElementById("menuForm").reset();
  document.getElementById("menu-id").value = "";
  document.getElementById("image-group").style.display = "block";
  document.getElementById("menu-preview-img").style.display = "none";
  document.getElementById("menuModal").style.display = "block";
  loadDanhMucOptions();
  document.getElementById("menu-trangthai").value = "Còn hàng"; // Mặc định
}

function editMenuItem(id, tenmon, gia, danhmuc, ghichu, hinhanh, trangthai) {
  document.getElementById("modal-title-menu").textContent = "Sửa Món Ăn";
  document.getElementById("menu-id").value = id;
  document.getElementById("menu-tenmon").value = tenmon;
  document.getElementById("menu-gia").value = gia;
  document.getElementById("menu-ghichu").value = ghichu;
  document.getElementById("menu-trangthai").value = trangthai;

  const imgPreview = document.getElementById("menu-preview-img");
  if (hinhanh) {
    imgPreview.src = `../img/${hinhanh}`;
    imgPreview.style.display = "block";
  } else {
    imgPreview.src = "";
    imgPreview.style.display = "none";
  }

  document.getElementById("image-group").style.display = "block";
  document.getElementById("menuModal").style.display = "block";
  loadDanhMucOptions(danhmuc);
}

function closeMenuModal() {
  document.getElementById("menuModal").style.display = "none";
}

function deleteMenuItem(id) {
  if (!confirm("Bạn có chắc muốn xóa món ăn này?")) return;

  fetch("../php/danhsachmonan.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=delete_menu&id=${id}`,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Đã xóa món ăn!");
        loadMenuItems();
      } else {
        alert("Xóa thất bại!");
      }
    })
    .catch(() => alert("Lỗi khi xóa món ăn"));
}

document.getElementById("menuForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const gia = parseFloat(document.getElementById("menu-gia").value.trim());
  if (isNaN(gia) || gia < 1000) {
    alert("Giá món ăn phải là số và từ 1.000 trở lên!");
    return;
  }

  const formData = new FormData(this);
  const id = document.getElementById("menu-id").value;
  formData.append("action", id ? "update_menu" : "add_menu");

  fetch("../php/danhsachmonan.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert(id ? "Cập nhật thành công!" : "Thêm món ăn thành công!");
        closeMenuModal();
        loadMenuItems();
      } else {
        alert(
          data.error ||
            (id ? "Cập nhật không thành công" : "Thêm không thành công")
        );
      }
    })
    .catch(() => alert("Có lỗi xảy ra khi gửi dữ liệu!"));
});

function loadDanhMucOptions(selected = "") {
  fetch("../php/get_danhmuc.php")
    .then((res) => res.json())
    .then((data) => {
      const select = document.getElementById("menu-danhmucmon");
      select.innerHTML = "";

      const defaultOption = document.createElement("option");
      defaultOption.textContent = "— Chọn danh mục —";
      defaultOption.disabled = true;
      defaultOption.selected = !selected;
      select.appendChild(defaultOption);

      data.forEach((dm) => {
        const option = document.createElement("option");
        option.value = dm.madanhmuc;
        option.textContent = dm.tendanhmuc;
        if (String(dm.madanhmuc) === String(selected)) option.selected = true;
        select.appendChild(option);
      });
    })
    .catch((err) => {
      console.error("❌ Lỗi khi fetch danh mục:", err);
      alert("Không tải được danh mục món ăn!");
    });
}

function updateTrangThai(id, trangthai) {
  fetch("../php/danhsachmonan.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=update_trangthai&id=${id}&trangthai=${encodeURIComponent(
      trangthai
    )}`,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        console.log("✅ Trạng thái đã cập nhật");
      } else {
        alert("❌ Cập nhật trạng thái thất bại");
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Lỗi kết nối khi cập nhật trạng thái!");
    });
}

document.addEventListener("DOMContentLoaded", loadMenuItems);

window.onclick = (e) => {
  const modal = document.getElementById("menuModal");
  if (e.target === modal) closeMenuModal();
};
