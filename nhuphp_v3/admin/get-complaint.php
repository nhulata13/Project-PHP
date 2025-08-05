<?php
require_once('../DataProvider.php');

if (isset($_GET['invoiceID'])) {
    $invoiceID = intval($_GET['invoiceID']);
    $sql = "SELECT * FROM complaint WHERE InvoiceID = $invoiceID LIMIT 1";
    $rs = DataProvider::executeQuery($sql);

    if ($row = mysqli_fetch_assoc($rs)) {
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
}
?>
