<!DOCTYPE html>
<html lang="vi">
<?php
	include('php/sessionAdmin.php');
?>

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
				<div id="main" class="col-md-12">
				<a href="adminproducts.php" class="btn btn-primary"> <i class="fa fa-home"></i></a> <!-- Change 'index.php' to your homepage URL -->

					<?php
						if(!isset($_POST['txtID']))
							header("Location: adminproducts.php");
						//Initiation
						$sql = "SELECT * FROM Product INNER JOIN ProductType WHERE Product.ProductTypeID = ProductType.ProductTypeID AND ProductID = '".$_POST['txtID']."'";
						$sql_type = "SELECT DISTINCT * FROM ProductType";
						//--Initiation

						//Execute Query
						require_once("../DataProvider.php");
						$rs = DataProvider::executeQuery($sql);
						$rs_Type = DataProvider::executeQuery($sql_type);
						//--Execute Query

						//Show
						while($row = mysqli_fetch_array($rs,MYSQLI_BOTH))
						{
							echo "<form name='editProducts' id='editProducts' action='adminproducts.php' method='POST' onsubmit='return confirmDel()'>";
							echo "<input name='txtID' id='txtID' type='hidden' value='".$_POST['txtID']."'>";
							echo "<div class='col-md-3'>";
							echo "<img src='../img/".$row["imgsrc"]."' width='258px' height='344px' alt='".$row["ProductName"]."'>";
							echo "</div>";
							echo "<div class='col-md-6'>";
							echo "<span class='text-uppercase'>Tên Sản Phẩm: </span>";
							echo "<input name='qtxtProductName' id='qtxtProductName' type='text' value='".$row['ProductName']."'>";
							echo "<br><br>";

							// Loại sản phẩm với dấu *
							echo "<span class='text-uppercase'>Loại <span style='color:red;'>*</span>: </span>";
							echo "<select name='qslcProductType' id='qslcProductType'>";

							// Mảng để lưu các loại sản phẩm duy nhất
							$productTypes = array();

							// Lặp qua các loại sản phẩm
							while($row_type = mysqli_fetch_array($rs_Type, MYSQLI_BOTH)) {
								$productTypeName = $row_type['ProductTypeName'];
								
								// Kiểm tra nếu tên loại sản phẩm chưa tồn tại trong mảng
								if (!in_array($productTypeName, $productTypes)) {
									$productTypes[] = $productTypeName;  // Thêm vào mảng các loại sản phẩm duy nhất
									
									// Kiểm tra nếu loại sản phẩm này là loại của sản phẩm đang chỉnh sửa
									$selected = ($row_type['ProductTypeID'] == $row['ProductTypeID']) ? "selected" : "";
									echo "<option value='".$productTypeName."' $selected>".$productTypeName."</option>";
								}
							}

							echo "</select>";

							echo "<br><br>";

							echo "<span class='text-uppercase'>Giá: </span>";
							echo "<input name='qtxtPrice' id='qtxtPrice' type='text' value='".number_format($row['UnitPrice'], 0, '', '.')."' oninput='formatPrice(this)'>";

							echo "<br><br>";
							

							echo "<span class='text-uppercase'>Số Lượng: </span>";
							echo "<input name='qtxtQuantity' id='qtxtQuantity' type='number' min=0 value='".$row['Quantity']."'>";
							echo "<br><br>";

							echo "<span class='text-uppercase'>Mô tả: </span>";
							echo "<input name='qtxtDescription' id='qtxtDescription' type='text' value='".$row['Description']."'>";
							echo "<br><br>";

							echo "<span class='text-uppercase'>Ngày thêm hàng: </span>";
							echo "<span class='text-uppercase'>".$row['Date']."</span>";
							echo "<br><br>";

							echo "<input type='submit' name='btnEditDel' class='primary-btn edit-del' value='Sửa'>";
							echo "<input type='submit' name='btnEditDel' class='primary-btn edit-del' value='Xóa'>";
							echo "</div>";
							echo "</form>";
						}
						//--Show
					?>
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
