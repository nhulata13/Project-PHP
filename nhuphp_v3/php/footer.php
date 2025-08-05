<?php
    if($_SESSION['isLogin']==0)
    {
?>
    <ul class="list-links">
        <li><a href="">Liên hệ</a></li>
        <li><a href="">Chính sách Đại Lý/NPP </a></li>
        <li><a href="">Điều khoản sử dụng</a></li>
        <li><a href="">Chính sách bảo mật</a></li>
    </ul>
<?php
    }
    else
    {
?>
    <ul class="list-links">
        <li><a href="">Liên hệ</a></li>
        <li><a href="">Chính sách Đại Lý/NPP </a></li>
        <li><a href="">Điều khoản sử dụng</a></li>
        <li><a href="">Chính sách bảo mật</a></li>
    </ul>
<?php
    }
?>