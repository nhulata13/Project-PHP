<?php
require_once('DataProvider.php');
require 'vendor/autoload.php'; // Đảm bảo đã cài PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$verified = false;
$message = '';

if (isset($_GET['email']) && isset($_GET['code'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];

    $sql = "SELECT * FROM Usr WHERE Email = '$email' AND VerifyCode = '$code' AND Verified = 0";
    $rs = DataProvider::executeQuery($sql);

    if (mysqli_num_rows($rs) == 1) {
        $row = mysqli_fetch_assoc($rs);
        $fullname = $row['UsrName'];

        // Cập nhật xác minh
        $update = "UPDATE Usr SET Verified = 1 WHERE Email = '$email'";
        DataProvider::executeQuery($update);

        // Gửi email cho chủ shop
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lly.htq@gmail.com';  // email chủ shop
            $mail->Password = 'nosp weno wpgx noxi'; // app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('lly.htq@gmail.com', 'Hệ thống Hoàng Phát');
            $mail->addAddress('lly.htq@gmail.com', 'Chủ Shop');

            $mail->isHTML(true);
            $mail->Subject = '✅ Khách hàng xác thực tài khoản thành công';

            $mail->Body = "
                <h3>Thông báo từ hệ thống Hoàng Phát</h3>
                <p>Một khách hàng đã xác thực tài khoản:</p>
                <ul>
                    <li><b>Họ tên:</b> {$fullname}</li>
                    <li><b>Email:</b> {$email}</li>
                    <li><b>Thời gian:</b> " . date('d/m/Y H:i:s') . "</li>
                </ul>
                <p>Vui lòng liên hệ nếu cần hỗ trợ khách hàng sớm.</p>
                <hr>
                <p><i>Đây là email tự động từ hệ thống.</i></p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Không gửi được email tới chủ shop: {$mail->ErrorInfo}");
        }

        $verified = true;
        $message = "🎉 Email xác nhận thành công! Bạn có thể đăng nhập ngay.";
    } else {
        $message = "⚠️ Liên kết không hợp lệ hoặc tài khoản đã được xác nhận.";
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác minh tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <h2 class="mb-4">Xác minh tài khoản</h2>
    <p class="fs-5">
        <?= $message ?>
    </p>

    <?php if ($verified): ?>
        <a href="signin.php" class="btn btn-custom mt-3">Đăng nhập ngay</a>
    <?php else: ?>
        <a href="index.php" class="btn btn-secondary mt-3">Trang chủ</a>
    <?php endif; ?>
</div>

</body>
</html>
