<?php
session_start();
require_once('../DataProvider.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceID = intval($_POST['ServiceID']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $orderDate = date('Y-m-d H:i:s');
    $status = 'Chờ xử lý';

    // Nếu người dùng đã đăng nhập
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $sqlUser = "SELECT * FROM usr WHERE Email = '$email'";
        $resultUser = DataProvider::executeQuery($sqlUser);
        $user = mysqli_fetch_assoc($resultUser);

        $usrName = $user['UsrName'];
        $phone = $user['PhoneNo'];
        $address = $user['Address'];

        $sql = "INSERT INTO orders (Email, UsrName, PhoneNo, Address, ServiceID, OrderDate, Status)
                VALUES ('$email', '$usrName', '$phone', '$address', $serviceID, '$orderDate', '$status')";
    } else {
        // Người dùng chưa đăng nhập
        $email = $_POST['Email'];
        $usrName = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO orders (Email, UsrName, PhoneNo, Address, ServiceID, OrderDate, Status)
                VALUES ('$email', '$usrName', '$phone', '$address', $serviceID, '$orderDate', '$status')";
    }

    DataProvider::executeQuery($sql);

    echo "<script>alert('Đơn hàng đã được gửi thành công!'); window.location='../index.php';</script>";
    exit;
}
?>
