
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

			<!-- row -->
			<div class="row row-admin">
				<!-- MAIN -->
        <div id="wrapper">
        <?php
		require_once('../DataProvider.php'); 

		$sql = "SELECT ProductID, ProductName, Brand FROM product WHERE block = 0";
		$rs = DataProvider::executeQuery($sql); 
		$products = [];
		while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) { 
			$products[] = $row;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-add'])) {
			$selectedProducts = $_POST['selectedProducts'] ?? [];
			$content = $_POST['content'] ?? '';

			if (empty($selectedProducts)) {
				echo "<script>alert('Vui lòng chọn ít nhất một sản phẩm!');</script>";
			} elseif (empty($content)) {
				echo "<script>alert('Vui lòng nhập nội dung bài viết!');</script>";
			} else {
				foreach ($selectedProducts as $productID) {
					$productID = intval($productID); 
					$updateSQL = "UPDATE product SET Note = '$content' WHERE ProductID = $productID";
					DataProvider::executeQuery($updateSQL); 
				}
				echo "<script>alert('Cập nhật ghi chú thành công!');</script>";
			}
		}
		?>


          <h1 class="text-center">Quản lý bài viết sản phẩm</h1>
          <!-- Hiển thị bảng sản phẩm -->
          <form action="" method="POST">
              <table class="table table-bordered table-striped">
                  <thead class="table-dark">
                      <tr>
                          <th>Chọn</th>
                          <th>Tên sản phẩm</th>
                          <th>Thương hiệu</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($products as $product) : ?>
                          <tr>
                              <td>
                                  <input type="checkbox" name="selectedProducts[]" value="<?= $product['ProductID']; ?>">
                              </td>
                              <td><?= $product['ProductName']; ?></td>
                              <td><?= $product['Brand']; ?></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>

              <textarea class="tinymce" id="" name="content" cols="30" rows="30"></textarea>
              <button type="submit" name="btn-add" class="btn btn-primary mt-3">Thêm bài viết</button>
          </form>
        </div>
          <!-- /MAIN -->		 
			</div>
			<!-- /row -->
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
