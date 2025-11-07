<?php
require_once('../DataProvider.php');

if (!isset($_GET['id'])) {
    header("Location: admin-services.php");
    exit;
}

$serviceID = intval($_GET['id']);

$sql = "SELECT * FROM service WHERE ServiceID = $serviceID";
$result = DataProvider::executeQuery($sql);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    echo "<script>alert('Không tìm thấy dịch vụ'); window.location.href='admin-services.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['ServiceName'];
    $description = $_POST['Description'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s');

    // Kiểm tra xem có ảnh mới không
    if (isset($_FILES['Imgsrc']) && $_FILES['Imgsrc']['error'] === 0) {
        $targetDir = "../img/";
        $fileName = basename($_FILES["Imgsrc"]["name"]);
        $targetFile = $targetDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["Imgsrc"]["tmp_name"], $targetFile)) {
                $imgsrc = $fileName;
                // Cập nhật cả ảnh
                $sql = "UPDATE service SET ServiceName='$name', Description='$description', Date='$date', Imgsrc='$imgsrc' WHERE ServiceID=$serviceID";
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
        $sql = "UPDATE service SET ServiceName='$name', Description='$description', Date='$date' WHERE ServiceID=$serviceID";
    }

    DataProvider::executeQuery($sql);
    header("Location: admin-services.php");
    exit;
}
?>
<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
?>
<?php
	ob_start();
?>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>HOÀNG PHÁT</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded|Encode+Sans+Semi+Condensed" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="../css/style.css" />
	<link type="text/css" rel="stylesheet" href="../css/extrastyle.css">
	<link type="text/css" rel="stylesheet" href="../css/adminbonus.css">

	<script src="../js/extrafunction.js"></script>
	<script src="js/admin.js"></script>
    <script src="https://cdn.tiny.cloud/1/0wv0ybdwfxe91cmzjmet1k5yqc2o41x29fedc1vgpwql0a98/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: '.tinymce',
        plugins: 'advlist autolink lits link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating'
        });
    </script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
    <script src="https://cdn.tiny.cloud/1/0wv0ybdwfxe91cmzjmet1k5yqc2o41x29fedc1vgpwql0a98/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector: '.tinymce' });</script>
</head>
<body>
     <!-- HEADER -->
	<header>
		<?php
			if($_SESSION['isLogin']==1)
			{
				require_once('../DataProvider.php');
				$sql="SELECT * FROM Usr WHERE Email='".$_SESSION['username']."'";
				$Usr=DataProvider::executeQuery($sql);
				$rowUsr=mysqli_fetch_array($Usr,MYSQLI_BOTH);
			}
		?>

		<!-- header -->
		<div id="header">
			<div class="container">
				
				<div class="pull-right">
					<ul class="header-btns">
						<?php include('php/account.php'); ?>

						<!-- <li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li> -->
					</ul>
				</div>
			</div>
		</div>

	</header>
	<!-- /HEADER -->
     <!-- section -->
    <div class="section">
		<!-- container -->
		<div class="container container-admin">
            <?php include('php/navigationUsr.php'); ?>

			<div class="row row-admin">
                <div class="col-md-12">
                        <h2 class="text-center">Chỉnh sửa Dịch Vụ</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên dịch vụ</label>
                                <input type="text" name="ServiceName" class="form-control" required value="<?php echo htmlspecialchars($service['ServiceName']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh hiện tại:</label><br>
                                <img src="../img/<?php echo $service['Imgsrc']; ?>" width="150" alt="Ảnh dịch vụ">
                            </div>
                            <div class="form-group">
                                <label>Chọn ảnh mới (nếu muốn thay):</label>
                                <input type="file" name="Imgsrc" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="Description" class="form-control tinymce" rows="6"><?php echo htmlspecialchars($service['Description']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="admin-services.php" class="btn btn-secondary">Hủy</a>
                        </form>
                </div>
                
            </div> 
        </div>
		<!-- /container -->
	</div>
	<!-- /section -->
    
<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>
