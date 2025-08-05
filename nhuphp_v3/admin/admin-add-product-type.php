<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
?>
<?php
	ob_start();
?>
<html lang="vi">

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

	<script src='js/admin.js'></script>

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
			<?php
				require_once('../DataProvider.php');

				// Xử lý thêm loại sản phẩm
				if (isset($_POST['btnAddProductType'])) {
					$productName = $_POST['ttxtProductName'];

					// Kiểm tra trùng loại sản phẩm
					$sql = "SELECT * FROM ProductType WHERE ProductTypeName = '$productName'";
					$rs = DataProvider::executeQuery($sql);
					
					if (mysqli_num_rows($rs) > 0) {
						echo "<script>alert('Danh mục [$productName] đã tồn tại');</script>";
					} else {
						$sql = "INSERT INTO ProductType (ProductTypeName) VALUES ('$productName')";
						DataProvider::executeQuery($sql);
						echo "<script>alert('Thêm Danh mục thành công');</script>";
						header("Location: admin-add-product-type.php");
					}
				}
			?>

			<div id="main" class="col-md-12">
				<form action="admin-add-product-type.php" method="POST">
					<span class='text-uppercase'>Tên danh mục: </span>
					<input type="text" name="ttxtProductName" required>
					<br><br>
					<input name='btnAddProductType' type='submit' value='Thêm danh mục'>
				</form>
			</div>

			<div id="main" class="col-md-12">
				<table border=1>
					<tr>
						<th>Danh mục</th>
						<th></th>
					</tr>
					<?php
						$sql = "SELECT * FROM ProductType ORDER BY ProductTypeName"; 
						$rs = DataProvider::executeQuery($sql);

						while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
							echo "<tr>";
							echo "<td>".$row['ProductTypeName']."</td>";

							// Nút XÓA
							echo "<td>
								<form action='admin-add-product-type.php' method='POST' onsubmit='return confirm(\"Bạn chắc chắn muốn xóa loại sản phẩm này?\");'>
									<input type='hidden' name='deleteProductTypeID' value='".$row['ProductTypeID']."'>
									<input type='submit' name='btnDeleteProductType' value='Xóa'>
								</form>
							</td>";
							echo "</tr>";
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /section -->

<?php
		require_once('../DataProvider.php');

		// Check if the delete button was clicked
		if (isset($_POST['btnDeleteProductType'])) {
			// Get the ProductTypeID from the hidden field
			$productTypeID = $_POST['deleteProductTypeID'];

			// Check if there are any products that are NOT blocked
$sqlCheckProducts = "SELECT COUNT(*) AS count FROM Product 
                     WHERE ProductTypeID = '$productTypeID' AND (Block IS NULL OR Block != 1)";
$resultCheck = DataProvider::executeQuery($sqlCheckProducts);
$rowCheck = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC);

if ($rowCheck['count'] > 0) {
    // Có sản phẩm chưa bị block -> không cho xóa
    echo "<script>alert('Không thể xóa loại sản phẩm này vì vẫn còn sản phẩm đang hoạt động.');</script>";
}  else {
				// If no products, proceed to delete the product type
				$sql = "DELETE FROM ProductType WHERE ProductTypeID = '$productTypeID'";
				
				// Execute the query
				if (DataProvider::executeQuery($sql)) {
					echo "<script>alert('Xóa loại hàng thành công');</script>";
					header("Location: admin-add-product-type.php"); // Redirect to refresh the page
				} else {
					echo "<script>alert('Lỗi khi xóa loại hàng');</script>";
				}
			}
		}
		?>


	<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>

</body>

</html>
