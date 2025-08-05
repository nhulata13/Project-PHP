<?php
require_once('../DataProvider.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceId = $_POST['InvoiceID'];
    $paymentStatus = $_POST['payment_status'];

    $sql = "UPDATE Invoice SET `Payment Status` = '$paymentStatus' WHERE InvoiceID = '$invoiceId'";
    $result = DataProvider::executeQuery($sql);

    if ($result) {
        echo "Cập nhật trạng thái thanh toán thành công";
    } else {
        echo "Lỗi khi cập nhật";
    }
}
?>
