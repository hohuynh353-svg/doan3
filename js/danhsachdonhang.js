// Các trạng thái đơn hàng theo thứ tự
const STATUS_ORDER = [
  "Đang chờ xác nhận", // 0
  "Đã xác nhận", // 1
  "Đang giao hàng", // 2
  "Giao hàng thành công", // 3
  "Đã hủy", // 4 (ngoại lệ, luôn chọn được)
];

// Hàm chuyển trạng thái thành class CSS để đổi màu
function getStatusClass(status) {
  switch (status) {
    case "Đang chờ xác nhận":
      return "pending";
    case "Đã xác nhận":
      return "confirmed";
    case "Đang giao hàng":
      return "shipping";
    case "Giao hàng thành công":
      return "success";
    case "Đã hủy":
      return "cancelled";
    default:
      return "";
  }
}

// Gọi API để lấy danh sách đơn hàng
fetch("get_orders.php")
  .then((res) => res.json())
  .then((data) => {
    const tbody = document.getElementById("orders-tbody");
    tbody.innerHTML = "";

    data.forEach((order) => {
      const statusClass = getStatusClass(order.trangthai);
      const currentStatusIndex = STATUS_ORDER.indexOf(order.trangthai);

      // Tạo danh sách option trong select với trạng thái bị khóa nếu lùi lại
      let statusOptions = "";
      STATUS_ORDER.forEach((status, i) => {
        const selected = status === order.trangthai ? "selected" : "";
        const disabled =
          i < currentStatusIndex && status !== "Đã hủy" ? "disabled" : "";
        statusOptions += `<option value="${status}" ${selected} ${disabled}>${status}</option>`;
      });

      const row = document.createElement("tr");
      row.innerHTML = `
        <td>#${order.id}</td>
        <td>${order.user_id}</td>
        <td>${order.thoigian}</td>
        <td>${Number(order.tongtien).toLocaleString()} VNĐ</td>
        <td>
          <select class="order-status ${statusClass}" data-id="${order.id}">
            ${statusOptions}
          </select>
        </td>
        <td>
          <button class="btn btn-info" onclick="viewOrder(${
            order.id
          })">Xem</button>
        </td>
      `;

      tbody.appendChild(row);
    });

    // Bắt sự kiện thay đổi trạng thái
    document.querySelectorAll(".order-status").forEach((select) => {
      select.addEventListener("change", function () {
        const orderId = this.getAttribute("data-id");
        const newStatus = this.value;

        // Đổi class màu sắc
        this.className = `order-status ${getStatusClass(newStatus)}`;

        // Gửi yêu cầu cập nhật trạng thái
        fetch("update_order_status.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: orderId, trangthai: newStatus }),
        })
          .then((res) => res.text())
          .then((response) => {
            alert("Đã cập nhật trạng thái!");
          })
          .catch((error) => {
            alert("Lỗi khi cập nhật trạng thái.");
            console.error(error);
          });
      });
    });
  });

// Hiển thị form chi tiết đơn hàng
function viewOrder(orderId) {
  fetch("get_order_detail.php?id=" + orderId)
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("order-detail-content").innerHTML = html;
      document.getElementById("orderDetailModal").classList.remove("hidden");
    })
    .catch((err) => {
      alert("Không thể tải chi tiết đơn hàng.");
      console.error(err);
    });
}

// Ẩn form chi tiết đơn hàng
function closeOrderModal() {
  document.getElementById("orderDetailModal").classList.add("hidden");
}
