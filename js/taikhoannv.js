// taikhoannv.js

// Hàm mở modal thêm nhân viên
function openAddStaffModal() {
  document.getElementById("staffForm").reset();
  document.getElementById("staff-id").value = ""; // xóa id khi thêm mới
  document.getElementById("staff-modal-title").innerText =
    "Tạo tài khoản Nhân Viên";
  document.getElementById("staffModal").classList.remove("hidden");
}

// Hàm đóng modal
function closeStaffModal() {
  document.getElementById("staffModal").classList.add("hidden");
}

// Đóng modal khi click ra ngoài nội dung modal
window.addEventListener("click", function (event) {
  const modal = document.getElementById("staffModal");
  if (event.target === modal) {
    closeStaffModal();
  }
});

// Hàm gọi API POST chung
async function postNhanVien(data) {
  try {
    const response = await fetch("taikhoannv.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams(data),
    });

    const text = await response.text();
    console.log("PHẢN HỒI TỪ SERVER:", text); // Log để kiểm tra

    // Chuyển đổi JSON nếu hợp lệ
    return JSON.parse(text);
  } catch (error) {
    return { success: false, error: error.message };
  }
}

// Load danh sách nhân viên và hiển thị vào bảng
function loadStaffData() {
  const tbody = document.getElementById("staff-tbody");
  tbody.innerHTML = '<tr><td colspan="6">Đang tải...</td></tr>';

  fetch("taikhoannv.php")
    .then((res) => res.json())
    .then((data) => {
      tbody.innerHTML = "";
      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML =
          '<tr><td colspan="6">Không có nhân viên nào</td></tr>';
        return;
      }

      data.forEach((nv) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${nv.id}</td>
          <td>${nv.hoten}</td>
          <td>${nv.email}</td>
          <td>${nv.sdt}</td>
          <td>${new Date(nv.created_at).toLocaleDateString()}</td>
          <td>
            <button onclick="editStaff(${nv.id})">Sửa</button>
            <button onclick="deleteStaff(${nv.id})">Xóa</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch((err) => {
      console.error(err);
      tbody.innerHTML = '<tr><td colspan="6">Lỗi tải dữ liệu</td></tr>';
    });
}

// Hàm mở modal sửa, điền dữ liệu nhân viên vào form
async function editStaff(id) {
  try {
    const res = await fetch("taikhoannv.php");
    const data = await res.json();
    const nv = data.find((item) => item.id == id);
    if (!nv) {
      alert("Không tìm thấy nhân viên!");
      return;
    }

    // Điền dữ liệu vào form
    document.getElementById("staff-id").value = nv.id;
    document.getElementById("hoten").value = nv.hoten;
    document.getElementById("email").value = nv.email;
    document.getElementById("sdt").value = nv.sdt;
    document.getElementById("matkhau").value = ""; // Để trống khi sửa

    document.getElementById("staff-modal-title").innerText =
      "Sửa Thông Tin Nhân Viên";
    document.getElementById("staffModal").classList.remove("hidden");
  } catch (error) {
    alert("Lỗi khi lấy dữ liệu nhân viên: " + error.message);
  }
}

// Hàm xóa nhân viên
async function deleteStaff(id) {
  if (!confirm("Bạn chắc chắn muốn xóa nhân viên này?")) return;

  const result = await postNhanVien({ action: "delete_nhanvien", id });
  if (result.success) {
    alert("Xóa nhân viên thành công");
    loadStaffData(); // reload bảng
  } else {
    alert("Lỗi: " + (result.error || "Không xác định"));
  }
}

// Xử lý submit form thêm/sửa
document
  .getElementById("staffForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const id = document.getElementById("staff-id").value;
    const hoten = document.getElementById("hoten").value.trim();
    const email = document.getElementById("email").value.trim();
    const sdt = document.getElementById("sdt").value.trim();
    const matkhau = document.getElementById("matkhau").value;

    if (!hoten || !email || !sdt) {
      alert("Vui lòng nhập đầy đủ thông tin bắt buộc");
      return;
    }

    let result;
    if (id) {
      // Sửa nhân viên
      result = await postNhanVien({
        action: "edit_nhanvien",
        id,
        hoten,
        email,
        sdt,
        matkhau, // có thể để trống
      });
    } else {
      // Thêm nhân viên mới
      if (!matkhau) {
        alert("Mật khẩu là bắt buộc khi thêm mới nhân viên");
        return;
      }
      result = await postNhanVien({
        action: "add_nhanvien",
        hoten,
        email,
        sdt,
        matkhau,
      });
    }

    if (result.success) {
      alert(
        id
          ? "Cập nhật nhân viên thành công"
          : "Tạo tài khoản nhân viên thành công"
      );
      closeStaffModal();
      loadStaffData();
    } else {
      alert("Lỗi: " + (result.error || "Không xác định"));
    }
  });

// Load danh sách nhân viên khi trang tải xong
document.addEventListener("DOMContentLoaded", loadStaffData);
