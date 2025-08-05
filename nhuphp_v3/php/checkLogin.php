<?php
// người dùng đã đăng nhập
    if($_SESSION['isLogin']==1)
    {
        // dùng sql để lấy thông tin người dùng
        require_once('DataProvider.php');
        $sql="SELECT * FROM Usr WHERE Email='".$_SESSION['username']."'";
        $rs=DataProvider::executeQuery($sql);
        $rowUsr=mysqli_fetch_array($rs,MYSQLI_BOTH);
    }
?>