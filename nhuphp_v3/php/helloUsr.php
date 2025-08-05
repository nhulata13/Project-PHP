<?php
// hiển thị thông điệp lời chào đầu trang
    if($_SESSION['isLogin']==1)
        echo "<span>Welcome ".$rowUsr['UsrName']." 👫🌸</span>";
    else
        echo "<span>📢📢📢 Are you ready to experience the amazing features of our web? <a href='signin.php'><b>Log in</b></a> to explore today 🐰</span>";
?>