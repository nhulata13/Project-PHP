<?php
    session_start();
	include('../php/sessionStart.php');
	if($_SESSION['isLogin']==1)
	{
        if($_SESSION['Authentication']=='Usr')
        {
            echo "<script>alert('Bạn không có quyền trên trang này');</script>";
            echo "<script>document.location = '/yame/index.php';</script>";
        }
    }
    else
        header('Location: ../signin.php');
?>