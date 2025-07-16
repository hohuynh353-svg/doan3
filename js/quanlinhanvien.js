// Lấy danh sách nhân viên khi load trang
function loadEmployees() {
  const loading = document.getElementById("employees-loading");
  loading.classList.remove("hidden");

  fetch("../php/quanlinhanvien.php?action=get")
    .then((res) => res.json())
    .then((data) => {
      const tbody = document.getElementById("table-body-nhanvien");
      tbody.innerHTML = "";
      data.forEach((emp) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${emp.id}</td>
          <td>${emp.tennv}</td>
          <td>${emp.email}</td>
          <td>${emp.sdt}</td>
          <td>${emp.diachi}</td>
          <td>${emp.chucvu}</td>
          <td>${emp.gioitinh}</td>
          <td>${emp.ngaytao}</td>
          <td>
            <button onclick='editEmployee(${JSON.stringify(emp)})'>Sửa</button>
            <button onclick='deleteEmployee(${emp.id})'>Xóa</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
      loading.classList.add("hidden");
    })
    .catch((err) => {
      console.error(err);
      loading.classList.add("hidden");
      alert("Lỗi tải dữ liệu");
    });
}

// Mở modal thêm mới
function openEmployeesModal() {
  document.getElementById("employees-modal-title").innerText =
    "Thêm Nhân Viên Mới";
  document.getElementById("employeesForm").reset();
  document.getElementById("employees-id").value = "";
  document.getElementById("employeesModal").classList.remove("hidden");
}

// Mở modal sửa
function editEmployee(emp) {
  document.getElementById("employees-modal-title").innerText = "Sửa Nhân Viên";
  document.getElementById("employees-id").value = emp.id;
  const form = document.getElementById("employeesForm");
  form.tennv.value = emp.tennv;
  form.email.value = emp.email;
  form.sdt.value = emp.sdt;
  form.diachi.value = emp.diachi;
  form.chucvu.value = emp.chucvu;
  form.gioitinh.value = emp.gioitinh;
  document.getElementById("employeesModal").classList.remove("hidden");
}

// Đóng modal
function closeEmployeesModal() {
  document.getElementById("employeesModal").classList.add("hidden");
}

// Gửi form thêm/sửa
document
  .getElementById("employeesForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const id = document.getElementById("employees-id").value;
    const formData = new FormData(this);
    const action = id ? "update" : "add";
    if (id) formData.append("id", id);

    fetch(`../php/quanlinhanvien.php?action=${action}`, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          alert(
            id ? "Cập nhật nhân viên thành công!" : "Thêm nhân viên thành công!"
          );
          closeEmployeesModal();
          loadEmployees();
        } else {
          alert("Lỗi: " + data.message);
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Lỗi gửi dữ liệu");
      });
  });

// Xóa nhân viên
function deleteEmployee(id) {
  if (!confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) return;

  const formData = new FormData();
  formData.append("id", id);

  fetch("../php/quanlinhanvien.php?action=delete", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert("Xóa nhân viên thành công!");
        loadEmployees();
      } else {
        alert("Lỗi: " + data.message);
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Lỗi xóa dữ liệu");
    });
}

// Tự động load khi trang sẵn sàng
document.addEventListener("DOMContentLoaded", function () {
  loadEmployees();
});
