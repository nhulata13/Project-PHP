<?php
// kiểm tra giá trị coi đn hay chưa
    // chưa đăng nhập
    if($_SESSION['isLogin']==0)
    {
?>
<!-- đăng nhập và tạo tài khoản -->
<li class="header-account dropdown default-dropdown">
    <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
        <div class="header-btns-icon">
            <i class="fa fa-user-o"></i>
        </div>
    </div>
    <a href="signin.php" class="text-uppercase"></a>
    <ul class="custom-menu">
        <li><a href="signin.php"><i class="fa fa-unlock-alt"></i>Sign in</a></li>
        <li><a href="signin.php"><i class="fa fa-user-plus"></i>Sign up</a></li>
    </ul>
</li>
<?php
    }
    // đã đăng nhập
    else
    {
?>
<!-- hiển thị các lựa chọn cho người dùng và đăng xuất -->
<li class="header-account dropdown default-dropdown">
    <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
        <div class="header-btns-icon">
            <i class="fa fa-user-o"></i>
        </div>
        <!-- <strong class="text-uppercase">Account<i class="fa fa-caret-down"></i></strong> -->
    </div>
    <!-- php
        $UsrName=$rowUsr['UsrName'];
        if(strlen($UsrName)>9)
        $UsrName=mb_substr($UsrName,0,8,'UTF-8').'...';
        echo "<span class='text-uppercase'>$UsrName</span>";
     -->
    <ul class="custom-menu">
        <form method='POST' action='index.php'>
            <li><a href="check-invoice-user.php" name='btnMyAccount' class='primary-btn' style='font-size:12px; width:100%; margin-bottom:10px;'><i class="fa fa-unlock-alt"></i> Tài khoản của tôi</a></li>
            <li><button name='btnLogOut' class='primary-btn' style='font-size:12px; width:100%;'><i class="fa fa-user-plus"></i> Đăng xuất</button></li>
        </form>
    </ul>
</li>
<?php
    }
?>