<?php
    session_start(); //lưu trữ thông tin giỏ hàng qua các phiên dùng
    
    $txtURL=$_POST['txtURL'];
    $ProductID=$_POST['txtProductID'];
    $Quatity=$_POST['txtQuantity'];
	
    // kiểm tra nút thêm
    if(isset($_POST['btnAddToCart']))
    {
        if(isset($_SESSION['Cart'][$ProductID]))
            $_SESSION['Cart'][$ProductID]+=$Quatity;
        else
            $_SESSION['Cart'][$ProductID]=$Quatity;
    }   
    //kiểm tra update 
    if(isset($_POST['btnUpdate']))
        $_SESSION['Cart'][$ProductID]=$Quatity;
// kiểm tra xóa sp
    if(isset($_POST['btnDel']))
        unset($_SESSION['Cart'][$ProductID]);
// ktra xoa hết sp
    if(isset($_POST['btnDelAll']))
        unset($_SESSION['Cart']);

    header('Location: '.$txtURL);
    exit;
?>