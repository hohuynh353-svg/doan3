function loadNhanVien() {
    fetch("load_nhanvien.php")
    .then(res => res.text())
    .then(data => {
        document.querySelector("#table-body-nhanvien").innerHTML = data;
    });
}
