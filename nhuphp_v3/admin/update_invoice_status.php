<?php
require_once('../DataProvider.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoiceID = $_POST['InvoiceID'];
    $status = $_POST['status'];

    $sqlUpdate = "UPDATE Invoice SET Status = '$status' WHERE InvoiceID = '$invoiceID'";
    DataProvider::executeQuery($sqlUpdate);

    if ($status == "Đơn bị Hủy") {
        $sqlItems = "SELECT ProductID, Quantities FROM InvoiceDetails WHERE InvoiceID = '$invoiceID'";
        $rsItems = DataProvider::executeQuery($sqlItems);

        while ($item = mysqli_fetch_array($rsItems, MYSQLI_ASSOC)) {
            $productID = $item['ProductID'];
            $quantity = $item['Quantities'];

            $sqlUpdateProduct = "UPDATE Product SET Quantity = Quantity + $quantity WHERE ProductID = $productID";
            DataProvider::executeQuery($sqlUpdateProduct);
        }
    }

    echo "success";
} else {
    echo "invalid_request";
}
?>
