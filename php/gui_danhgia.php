<?php
include 'connect.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Nhận dữ liệu từ form
$hoten = $_POST['reviewerName'];
$noidung = $_POST['reviewContent'];
$sosao = $_POST['rating'];

// Kiểm tra dữ liệu
if (!empty($hoten) && !empty($noidung) && !empty($sosao)) {
    $stmt = $conn->prepare("INSERT INTO danhgia (hoten, noidung, sosao) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $hoten, $noidung, $sosao);

    if ($stmt->execute()) {
        echo "<script>
                alert('Đánh giá đã được ghi nhận!');
                window.location.href = 'trang_danhgia.php';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi khi ghi dữ liệu: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Vui lòng điền đầy đủ thông tin!');
            window.history.back();
          </script>";
}

$conn->close();
?>
