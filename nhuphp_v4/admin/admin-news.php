<?php
require_once('../DataProvider.php');

// Xử lý khi bấm nút xoá
if (isset($_GET['delete_id'])) {
    $newsID = intval($_GET['delete_id']);
    $sqlDelete = "DELETE FROM news WHERE NewsID = $newsID";
    DataProvider::executeQuery($sqlDelete);
}
?>

<!DOCTYPE html>
<?php include('php/sessionAdmin.php'); ?>
<?php ob_start(); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HOÀNG PHÁT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded|Encode+Sans+Semi+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/extrastyle.css">
    <link rel="stylesheet" href="../css/adminbonus.css">

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/0wv0ybdwfxe91cmzjmet1k5yqc2o41x29fedc1vgpwql0a98/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating'
        });
    </script>
</head>

<body>
<header>
    <?php
    if ($_SESSION['isLogin'] == 1) {
        $sql = "SELECT * FROM Usr WHERE Email='" . $_SESSION['username'] . "'";
        $Usr = DataProvider::executeQuery($sql);
        $rowUsr = mysqli_fetch_array($Usr, MYSQLI_BOTH);
    }
    ?>
    <div id="header">
        <div class="container">
            <div class="pull-right">
                <ul class="header-btns">
                    <?php include('php/account.php'); ?>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="section">
    <div class="container container-admin">
        <?php include('php/navigationUsr.php'); ?>

        <div class="row row-admin">
            <div class="col-md-12">
                <h2 class="admin-header text-center">Quản lý tin tức</h2>

                <div class="text-right mb-3">
                    <a href="admin_add_news.php" class="btn btn-success">+ Thêm tin tức</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Ngày đăng</th>
                            <th>Mô tả</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM news";
                        $result = DataProvider::executeQuery($sql);

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['NewsID']}</td>";
                            echo "<td><img src='../img/" . htmlspecialchars($row["ImgSrc"]) . "' width='150px' height='150px' alt='" . htmlspecialchars($row["NewsTitle"]) . "'></td>";
                            echo "<td>" . htmlspecialchars($row['NewsTitle']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                            echo "<td>" . mb_substr(strip_tags($row['Description']), 0, 80) . "...</td>";
                            echo "<td>
                                    <a href='admin_edit_news.php?id={$row['NewsID']}' class='btn btn-primary btn-sm'>Sửa</a>
                                    <a href='admin-news.php?delete_id={$row['NewsID']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá tin tức này?');\">Xoá</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
