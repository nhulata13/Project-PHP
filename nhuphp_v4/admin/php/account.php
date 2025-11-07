<!-- Account -->
<?php
    if($_SESSION['isLogin']==0)
    {
?>
<li class="header-account dropdown default-dropdown">
    <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
        <div class="header-btns-icon">
            <i class="fa fa-user-o"></i>
        </div>
        <strong class="text-uppercase">Tài khoản <i class="fa fa-caret-down"></i></strong>
    </div>
    <a href="signin.php" class="text-uppercase">Đăng nhập</a>
    <ul class="custom-menu">
        <li><a href="signin.php"><i class="fa fa-unlock-alt"></i>Đăng nhập</a></li>
        <li><a href="signin.php"><i class="fa fa-user-plus"></i>Tạo tài khoản</a></li>
    </ul>
</li>
<?php
    }
    else
    {
?>
<li class="header-account dropdown default-dropdown">
    <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
        <div class="header-btns-icon">
            <i class="fa fa-user-o"></i>
        </div>
        <strong class="text-uppercase">Tài khoản <i class="fa fa-caret-down"></i></strong>
    </div>
    <?php
        $UsrName=$rowUsr['UsrName'];
        if(strlen($UsrName)>9)
        $UsrName=mb_substr($UsrName,0,8,'UTF-8').'...';
        echo "<span class='text-uppercase'>$UsrName</span>";
    ?>
    <ul class="custom-menu">
        <?php
            require_once('../DataProvider.php');
            $sql="SELECT * FROM AuthenticationUsr WHERE Authentication='".$_SESSION['Authentication']."'";
            $rs=DataProvider::executeQuery($sql);
            $row=mysqli_fetch_array($rs,MYSQLI_BOTH);
            echo "<p>Quyền Admin: ".$row['AuthenticationName']."</p>";
        ?>
        <form method='POST' action='../index.php'>
            <li><button name='btnLogOut' class='primary-btn' style='font-size:12px; width:100%;'><i class="fa fa-user-plus"></i> Đăng xuất</button></li>
        </form>
    </ul>
</li>
<?php
    }
?>
<!-- /Account -->