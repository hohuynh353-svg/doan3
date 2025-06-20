// Script xử lý thêm/sửa/xoá nhân viên trong modal employeesModal

document.addEventListener("DOMContentLoaded", () => {
  loadEmployees();

  document
    .getElementById("employeesForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);
      const data = {
        action: form["employees-id"].value ? "edit_nhanvien" : "add_nhanvien",
        id: form["employees-id"].value,
        tennv: form["tennv"].value.trim(),
        email: form["email"].value.trim(),
        sdt: form["sdt"].value.trim(),
        diachi: form["diachi"].value.trim(),
        chucvu: form["chucvu"].value,
        gioitinh: form["gioitinh"].value,
      };

      if (!data.tennv || !data.email || !data.sdt || !data.diachi) {
        alert("Vui lòng nhập đầy đủ thông tin.");
        return;
      }

      try {
        const response = await fetch("php/themnv.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams(data),
        });
        const result = await response.json();

        if (result.success) {
          alert(data.id ? "Cập nhật thành công" : "Thêm mới thành công");
          form.reset();
          closeEmployeesModal();
          loadEmployees();
        } else {
          alert("Lỗi: " + (result.error || "Không xác định"));
        }
      } catch (err) {
        alert("Lỗi gửi dữ liệu: " + err.message);
      }
    });
});

function closeEmployeesModal() {
  document.getElementById("employeesModal").style.display = "none";
}

function openEmployeesModal(data = null) {
  const form = document.getElementById("employeesForm");
  form.reset();
  form["employees-id"].value = data?.id || "";
  form["tennv"].value = data?.tennv || "";
  form["email"].value = data?.email || "";
  form["sdt"].value = data?.sdt || "";
  form["diachi"].value = data?.diachi || "";
  form["chucvu"].value = data?.chucvu || "Đầu bếp";
  form["gioitinh"].value = data?.gioitinh || "Nam";
  document.getElementById("employeesModal").style.display = "block";
}

async function loadEmployees() {
  const tbody = document.getElementById("employees-tbody");
  if (!tbody) return;
  tbody.innerHTML = "<tr><td colspan='8'>Đang tải...</td></tr>";

  try {
    const response = await fetch("php/themnv.php");
    const data = await response.json();
    if (!Array.isArray(data)) throw new Error("Dữ liệu không hợp lệ");

    tbody.innerHTML = "";
    data.forEach((nv) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${nv.id}</td>
        <td>${nv.tennv}</td>
        <td>${nv.email}</td>
        <td>${nv.sdt}</td>
        <td>${nv.diachi}</td>
        <td>${nv.chucvu}</td>
        <td>${nv.gioitinh}</td>
        <td>
          <button onclick='openEmployeesModal(${JSON.stringify(
            nv
          )})'>Sửa</button>
          <button onclick='deleteEmployee(${nv.id})'>Xoá</button>
        </td>`;
      tbody.appendChild(row);
    });
  } catch (err) {
    tbody.innerHTML = `<tr><td colspan='8'>Lỗi tải dữ liệu: ${err.message}</td></tr>`;
  }
}

async function deleteEmployee(id) {
  if (!confirm("Bạn có chắc chắn muốn xoá nhân viên này?")) return;
  try {
    const res = await fetch("php/themnv.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ action: "delete_nhanvien", id }),
    });
    const result = await res.json();
    if (result.success) {
      alert("Xoá thành công");
      loadEmployees();
    } else {
      alert("Lỗi xoá: " + result.error);
    }
  } catch (err) {
    alert("Lỗi gửi yêu cầu xoá: " + err.message);
  }
}
