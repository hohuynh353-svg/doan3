<?php
require 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0);
$trangthai = $data['trangthai'] ?? '';

// 1. Cập nhật trạng thái đơn hàng
$sql = "UPDATE donhang SET trangthai = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $trangthai, $id);
$stmt->execute();

// 2. Nếu trạng thái là "Giao hàng không thành công", xử lý bảng so_bi_chan
if ($trangthai === "Giao hàng không thành công") {
    // Lấy số điện thoại từ đơn hàng (ưu tiên) hoặc từ users
    $sql_get_sdt = "
        SELECT donhang.sdt AS sdt_don, users.sdt AS sdt_user 
        FROM donhang 
        LEFT JOIN users ON donhang.user_id = users.id 
        WHERE donhang.id = $id
    ";
    $res_sdt = mysqli_query($conn, $sql_get_sdt);
    $row = mysqli_fetch_assoc($res_sdt);

    $sdt = $row['sdt_don'] ?: $row['sdt_user'];

    if ($sdt) {
        $check_sql = "SELECT * FROM so_bi_chan WHERE sdt = '$sdt'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $data = mysqli_fetch_assoc($check_result);
            $solan = $data['solan_fail'] + 1;

            // Cập nhật trạng thái mới
            $trangthai_moi = 'binhthuong';
            if ($solan >= 5) $trangthai_moi = 'chan';
            else if ($solan >= 3) $trangthai_moi = 'canhbao';

            $update_sql = "
                UPDATE so_bi_chan 
                SET solan_fail = $solan, trangthai = '$trangthai_moi' 
                WHERE sdt = '$sdt'
            ";
            mysqli_query($conn, $update_sql);
        } else {
            $insert_sql = "
                INSERT INTO so_bi_chan (sdt, solan_fail, trangthai) 
                VALUES ('$sdt', 1, 'binhthuong')
            ";
            mysqli_query($conn, $insert_sql);
        }
    }
}

echo "Cập nhật thành công";
?>
