<?php
require_once('../DataProvider.php');

if (!isset($_GET['id'])) {
    header("Location: admin-news.php");
    exit;
}

$newsID = intval($_GET['id']);

$sql = "SELECT * FROM news WHERE NewsID = $newsID";
$result = DataProvider::executeQuery($sql);
$news = mysqli_fetch_assoc($result);

if (!$news) {
    echo "<script>alert('Không tìm thấy tin tức'); window.location.href='admin-news.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['NewsTitle'];
    $description = $_POST['Description'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s');

    // Kiểm tra ảnh mới
    if (isset($_FILES['ImgSrc']) && $_FILES['ImgSrc']['error'] === 0) {
        $targetDir = "../img/";
        $fileName = basename($_FILES["ImgSrc"]["name"]);
        $targetFile = $targetDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["ImgSrc"]["tmp_name"], $targetFile)) {
                $imgsrc = $fileName;
                $sql = "UPDATE news SET NewsTitle='$title', Description='$description', Date='$date', ImgSrc='$imgsrc' WHERE NewsID=$newsID";
            } else {
                echo "<script>alert('Không thể lưu file ảnh mới.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Chỉ cho phép file ảnh (jpg, jpeg, png, gif, webp)');</script>";
            exit;
        }
    } else {
        // Không cập nhật ảnh
        $sql = "UPDATE news SET NewsTitle='$title', Description='$description', Date='$date' WHERE NewsID=$newsID";
    }

    DataProvider::executeQuery($sql);
    header("Location: admin-news.php");
    exit;
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
    <script>tinymce.init({ selector: '.tinymce' });</script>
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
                <h2 class="text-center">Chỉnh sửa Tin Tức</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tiêu đề tin</label>
                        <input type="text" name="NewsTitle" class="form-control" required value="<?php echo htmlspecialchars($news['NewsTitle']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh hiện tại:</label><br>
                        <img src="../img/<?php echo $news['ImgSrc']; ?>" width="150" alt="Ảnh tin tức">
                    </div>
                    <div class="form-group">
                        <label>Chọn ảnh mới (nếu muốn thay)</label>
                        <input type="file" name="ImgSrc" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Mô tả / nội dung</label>
                        <textarea name="Description" class="form-control tinymce" rows="6"><?php echo htmlspecialchars($news['Description']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="admin-news.php" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
