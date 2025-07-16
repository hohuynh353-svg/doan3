<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Đường dẫn tới các file PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function sendResetEmail($to, $token) {
    $mail = new PHPMailer(true);

    try {
        // Cấu hình Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // ✅ Thay thông tin Gmail thật của bạn tại đây
        $mail->Username = 'ho353huynh@gmail.com';
        $mail->Password = 'yenf swdf kynl llmn'; // Dùng App Password, KHÔNG dùng mật khẩu Gmail

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Người gửi
        $mail->setFrom('ho353huynh@gmail.com', 'Hệ thống đặt cơm');
        $mail->addAddress($to);

        // Nội dung
        $mail->isHTML(true);
        $mail->Subject = 'Yêu cầu đặt lại mật khẩu';

        $link = "http://localhost/doan3/php/datlaimatkhau.php?token=$token";

        $mail->Body = "
            <h3>Đặt lại mật khẩu</h3>
            <p>Bạn nhận được email này vì đã yêu cầu đặt lại mật khẩu.</p>
            <p>Vui lòng click vào liên kết sau để đặt lại:</p>
            <p><a href='$link'>$link</a></p>
            <p><small>Liên kết sẽ hết hạn sau 1 giờ.</small></p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        // Ghi log nếu cần: $e->getMessage()
        return false;
    }
}
