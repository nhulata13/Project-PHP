<?php
require_once('../DataProvider.php');

// Xử lý khi bấm nút xoá
if (isset($_GET['delete_id'])) {
    $serviceID = intval($_GET['delete_id']);

    $sqlDelete = "DELETE FROM service WHERE ServiceID = $serviceID";
    DataProvider::executeQuery($sqlDelete);

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
<meta charset="utf-8">
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
          <h2 class="admin-header text-center">Quản lý dịch vụ</h2>

          <div class="text-right mb-3">
            <a href="admin_add_service.php" class="btn btn-success">+ Thêm dịch vụ</a>
          </div>

          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tên dịch vụ</th>
                <th>Ngày cập nhật</th>
                <th>Mô tả</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM service";
                $result = DataProvider::executeQuery($sql);

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                  echo "<tr>";
                  echo "<td>{$row['ServiceID']}</td>";
                  echo "<td><img src='../img/" . htmlspecialchars($row["Imgsrc"]) . "' width='150px' height='150px' alt='" . htmlspecialchars($row["ServiceName"]) . "' class='service-img'></td>";
                  echo "<td>{$row['ServiceName']}</td>";
                  echo "<td>{$row['Date']}</td>";
                  echo "<td>" . substr(strip_tags($row['Description']), 0, 80) . "...</td>";
                  echo "<td>
							<a href='admin_edit_service.php?id={$row['ServiceID']}' class='btn btn-primary btn-sm btn-action'>Sửa</a>
							<a href='admin-services.php?delete_id={$row['ServiceID']}'
							class='btn btn-danger btn-sm btn-action'
							onclick=\"return confirm('Bạn có chắc chắn muốn xoá dịch vụ này?');\">
							Xoá</a>
						</td>";

                  echo "</tr>";
                }
              ?>
            </tbody>
          </table>

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
