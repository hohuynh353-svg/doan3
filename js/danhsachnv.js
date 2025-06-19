// Hàm mở modal thêm nhân viên
function openEmployeesModal() {
  document.getElementById("employeesForm").reset();
  document.getElementById("employees-id").value = ""; // xóa id khi thêm mới
  document.getElementById("employees-modal-title").innerText =
    "Tạo tài khoản Nhân Viên";
  document.getElementById("employeesModal").style.display = "block";
}

// Hàm đóng modal
function closeEmployeesModal() {
  document.getElementById("employeesModal").style.display = "none";
}

// Đóng modal khi click ra ngoài nội dung modal
window.addEventListener("click", function (event) {
  const modal = document.getElementById("employeesModal");
  if (event.target === modal) {
    closeEmployeesModal();
  }
});

// Hàm gọi API POST chung
async function postNhanVien(data) {
  try {
    const response = await fetch("themnv.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams(data),
    });
    return await response.json();
  } catch (error) {
    return { success: false, error: error.message };
  }
}

// Load danh sách nhân viên và hiển thị vào bảng
function loadEmployeesData() {
  const tbody = document.getElementById("employees-tbody");
  tbody.innerHTML = '<tr><td colspan="7">Đang tải...</td></tr>';

  fetch("themnv.php")
    .then((res) => res.json())
    .then((data) => {
      tbody.innerHTML = "";
      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML =
          '<tr><td colspan="7">Không có nhân viên nào</td></tr>';
        return;
      }

      data.forEach((nv) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${nv.id}</td>
          <td>${nv.hoten}</td>
          <td>${nv.email}</td>
          <td>${nv.sdt}</td>
          <td>${nv.chucvu}</td>
          <td>${new Date(nv.created_at).toLocaleDateString()}</td>
          <td>
            <button onclick="editEmployees(${nv.id})">Sửa</button>
            <button onclick="deleteEmployees(${nv.id})">Xóa</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch((err) => {
      console.error(err);
      tbody.innerHTML = '<tr><td colspan="7">Lỗi tải dữ liệu</td></tr>';
    });
}

// Hàm mở modal sửa nhân viên
async function editEmployees(id) {
  try {
    const res = await fetch("themnv.php");
    const data = await res.json();
    const nv = data.find((item) => item.id == id);
    if (!nv) {
      alert("Không tìm thấy nhân viên!");
      return;
    }

    document.getElementById("employees-id").value = nv.id;
    document.getElementById("hoten").value = nv.hoten;
    document.getElementById("email").value = nv.email;
    document.getElementById("sdt").value = nv.sdt;
    document.getElementById("chucvu").value = nv.chucvu || "";

    document.getElementById("employees-modal-title").innerText =
      "Sửa Thông Tin Nhân Viên";
    document.getElementById("employeesModal").style.display = "block";
  } catch (error) {
    alert("Lỗi khi lấy dữ liệu nhân viên: " + error.message);
  }
}

// Hàm xóa nhân viên
async function deleteEmployees(id) {
  if (!confirm("Bạn chắc chắn muốn xóa nhân viên này?")) return;

  const result = await postNhanVien({ action: "delete_nhanvien", id });
  if (result.success) {
    alert("Xóa nhân viên thành công");
    loadEmployeesData();
  } else {
    alert("Lỗi: " + (result.error || "Không xác định"));
  }
}

// Xử lý submit form thêm/sửa nhân viên
document
  .getElementById("employeesForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const id = document.getElementById("employees-id").value;
    const hoten = document.getElementById("hoten").value.trim();
    const email = document.getElementById("email").value.trim();
    const sdt = document.getElementById("sdt").value.trim();
    const chucvu = document.getElementById("chucvu").value.trim();

    if (!hoten || !email || !sdt || !chucvu) {
      alert("Vui lòng nhập đầy đủ thông tin bắt buộc");
      return;
    }

    let result;
    if (id) {
      // Cập nhật nhân viên
      result = await postNhanVien({
        action: "edit_nhanvien",
        id,
        hoten,
        email,
        sdt,
        chucvu,
      });
    } else {
      // Thêm nhân viên mới
      result = await postNhanVien({
        action: "add_nhanvien",
        hoten,
        email,
        sdt,
        chucvu,
      });
    }

    if (result.success) {
      alert(
        id
          ? "Cập nhật nhân viên thành công"
          : "Tạo tài khoản nhân viên thành công"
      );
      closeEmployeesModal();
      loadEmployeesData();
    } else {
      alert("Lỗi: " + (result.error || "Không xác định"));
    }
  });

// Tải danh sách nhân viên khi trang sẵn sàng
document.addEventListener("DOMContentLoaded", loadEmployeesData);
