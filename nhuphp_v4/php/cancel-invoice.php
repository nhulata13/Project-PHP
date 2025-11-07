<?php
session_start();
include('../DataProvider.php');

if (isset($_GET['invoiceID'])) {
    $invoiceID = intval($_GET['invoiceID']);

    $sqlDeleteComplaint = "DELETE FROM complaint WHERE InvoiceID = $invoiceID";
    DataProvider::executeQuery($sqlDeleteComplaint);
    
    $sqlDeleteDetails = "DELETE FROM invoicedetails WHERE InvoiceID = $invoiceID";
    DataProvider::executeQuery($sqlDeleteDetails);

    $sqlDeleteInvoice = "DELETE FROM invoice WHERE InvoiceID = $invoiceID";
    DataProvider::executeQuery($sqlDeleteInvoice);

    header("Location: ../check-invoice-user.php");
    exit();
}
?>
