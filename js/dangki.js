function validateForm() {
  const hoten = document.getElementById("hoten").value.trim();
  const email = document.getElementById("email").value.trim();
  const sdt = document.getElementById("sdt").value.trim();
  const matkhau = document.getElementById("matkhau").value;
  const confirm = document.getElementById("confirm_matkhau").value;

  let valid = true;

  // Reset errors
  document
    .querySelectorAll(".error-message")
    .forEach((el) => (el.style.display = "none"));

  // Kiểm tra họ tên
  if (hoten === "") {
    showError("hoten", "Họ tên không được để trống");
    valid = false;
  }

  // Kiểm tra email hợp lệ
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    document.getElementById("email-error").style.display = "block";
    valid = false;
  }

  // Kiểm tra số điện thoại (10-11 số)
  const sdtPattern = /^\d{10,11}$/;
  if (!sdtPattern.test(sdt)) {
    showError("sdt", "Số điện thoại không hợp lệ (10-11 chữ số)");
    valid = false;
  }

  // Kiểm tra độ dài mật khẩu
  if (matkhau.length < 6) {
    document.getElementById("password-error").style.display = "block";
    valid = false;
  }

  // Kiểm tra xác nhận mật khẩu
  if (matkhau !== confirm) {
    document.getElementById("confirm-password-error").style.display = "block";
    valid = false;
  }

  return valid;
}

// Hàm tạo và hiển thị lỗi động
function showError(fieldId, message) {
  let errorSpan = document.querySelector(`#${fieldId}-error`);
  if (!errorSpan) {
    errorSpan = document.createElement("span");
    errorSpan.id = `${fieldId}-error`;
    errorSpan.className = "error-message";
    document
      .getElementById(fieldId)
      .insertAdjacentElement("afterend", errorSpan);
  }
  errorSpan.textContent = message;
  errorSpan.style.display = "block";
}
