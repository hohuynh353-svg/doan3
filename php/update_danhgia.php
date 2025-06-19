<?php
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if (in_array($action, ['duyet', 'an', 'xoa'])) {
        if ($action === 'xoa') {
            $sql = "DELETE FROM danhgia WHERE id = $id";
        } else {
            $sql = "UPDATE danhgia SET thaotac = '$action' WHERE id = $id";
        }

        if ($conn->query($sql)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>

<script>
function handleAction(action, id) {
    let actionText = '';

    switch (action) {
        case 'duyet':
            actionText = 'duyệt đánh giá này';
            break;
        case 'an':
            actionText = 'ẩn đánh giá này';
            break;
        case 'xoa':
            actionText = 'xóa đánh giá này';
            break;
    }

    // Hộp thoại xác nhận
    const confirmed = confirm(`Bạn có chắc muốn ${actionText}?`);

    if (!confirmed) return; // Người dùng bấm "Hủy" thì không làm gì cả

    // Nếu xác nhận OK → gửi dữ liệu lên server
    fetch('update_danhgia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&action=${action}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            alert('Cập nhật thành công');

            // Ẩn khỏi giao diện nếu là hành động ẩn hoặc xóa
            if (action === 'an' || action === 'xoa') {
                const reviewElement = document.getElementById('review-' + id);
                if (reviewElement) reviewElement.remove();
            }
        } else {
            alert('Cập nhật thành công!');
        }
    });
}
</script>


