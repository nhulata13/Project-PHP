<?php
    if($_SESSION['Authentication']!="Invoice")
    {
        echo "<script>alert('Bạn không có quyền trên trang này');</script>";
        echo "<script>document.location = '../index.php';</script>";
    }
?>