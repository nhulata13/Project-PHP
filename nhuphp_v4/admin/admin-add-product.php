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
				<!-- Search -->
				<!-- MAIN -->
				<div id="main" class="col-md-12">
				<a href="adminproducts.php" class="btn btn-primary"> <i class="fa fa-home"></i></a> <!-- Change 'index.php' to your homepage URL -->

					<form id='addProduct' name='addProduct' action='admin-add-product.php' method='POST' enctype="multipart/form-data" onsubmit='return checkAddProduct()'>
						<span id='lblNULL' style='color:red; display:none;'>*: Chưa nhập/Chưa chọn</span>
						<div class="form-row">
							<span class='text-uppercase'>Tên sản phẩm: </span>
							<?php 
								echo "<input type='text' name='atxtProductName' id='atxtProductName'";
								if(isset($_POST['atxtProductName']))
									echo" value = '".$_POST['atxtProductName']."'>";
								else
									echo ">";
							?>
							<span id='lblProductNameNULL' style='color:red; display:none;'>*</span>
							<br><br>

							<span class='text-uppercase'>Thương hiệu</span>
							<?php 
								echo "<input type='text' name='atxtBrandName' id='atxtBrandName'";
								if(isset($_POST['atxtBrandName']))
									echo" value = '".$_POST['atxtBrandName']."'>";
								else
									echo ">";
							?>
							<span id='lblBrandNameNULL' style='color:red; display:none;'>* chưa có</span>
							<br><br>
						</div>

						<div class="form-row">
							<span class='text-uppercase'>Loại sản phẩm: </span>
							<select name="aslcType" id='aslcType'>
								<?php
									require_once("../DataProvider.php");

									// Truy vấn lấy dữ liệu duy nhất của ProductTypeName
									$sql = "SELECT DISTINCT ProductTypeName FROM ProductType";
									$Type = DataProvider::executeQuery($sql);

									$type = "";
									if (isset($_POST['aslcType']))
										$type = $_POST['aslcType'];

									// Dữ liệu sẽ được lưu vào mảng để tránh trùng lặp
									$productTypes = array();

									// Lặp qua các dòng kết quả
									while ($row = mysqli_fetch_array($Type, MYSQLI_BOTH)) {
										// Loại bỏ khoảng trắng thừa trước và sau mỗi giá trị
										$productTypeName = trim($row['ProductTypeName']);

										// Chỉ thêm vào mảng nếu tên sản phẩm chưa tồn tại
										if (!in_array($productTypeName, $productTypes)) {
											$productTypes[] = $productTypeName;
										}
									}

									// Hiển thị giá trị đã chọn
									echo $type;

									// Thêm tùy chọn rỗng nếu chưa chọn
									if ($type == "")
										echo "<option value='' selected></option>";
									else
										echo "<option value=''></option>";

									// Hiển thị các tùy chọn cho danh sách
									foreach ($productTypes as $productTypeName) {
										if ($type == $productTypeName)
											echo "<option value='" . $productTypeName . "' selected>" . $productTypeName . "</option>";
										else
											echo "<option value='" . $productTypeName . "'>" . $productTypeName . "</option>";
									}
								?>
							</select>
							<span id='lblTypeNULL' style='color:red; display:none;'>*</span>
						</div>

					
						<div class="form-row">
							<span class='text-uppercase'>Giá: </span>
							<?php 
								echo "<input type='text' name='atxtPrice' id='atxtPrice' oninput='formatPrice(this)'";
								if (isset($_POST['atxtPrice']))
									echo " value='" . htmlspecialchars($_POST['atxtPrice'], ENT_QUOTES) . "'>";
								else
									echo ">";
							?>
							<span id='lblPriceNULL' style='color:red; display:none;'>*</span>
							<span id='lblPriceNoError' style='color:red; display:none;'>Giá nhập phải là số</span>

							<br><br>

							<span class='text-uppercase'>Số Lượng: </span>
							<?php 
								echo "<input type='text' name='atxtQuantity' id='atxtQuantity'";
								if(isset($_POST['atxtQuantity']))
									echo" value = ".$_POST['atxtQuantity'].">";
								else
									echo ">";
							?>
							<span id='lblQuantityNULL' style='color:red; display:none;'>*</span>
							<span id='lblQuantityNoError' style='color:red; display:none;'>Số lượng nhập phải là số</span>
							<br><br>
						</div>

						<span class='text-uppercase'>Mô tả sản phẩm</span>
						<?php 
							echo "<input type='text' name='atxtDescription' id='atxtDescription'";
							if(isset($_POST['atxtDescription']))
								echo" value = '".$_POST['atxtDescription']."'>";
							else
								echo ">";
						?>
						<span id='lblDescriptionNULL' style='color:red; display:none;'>* chưa có</span>
						<br><br>

						<span class='text-uppercase'>Chọn Hình: </span>
						<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
						<input type='file' name='afileImage' style='width:200px; display: inline-block;'>
						<span id='lblImageNULL' style='color:red; display:none;'>*</span>
						<p id='lblImgError' style='color:red; display:inline-block'></p>
						<br><br>

						<input name='btnAddProduct' type='submit' value='Thêm Hàng'>
						<input name='btnReset' type='reset' value='Làm lại'>
					</form>
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<?php
	require_once('../DataProvider.php');
	if(isset($_POST['btnAddProduct']))
	{
		$imgCheck=true;
		if(isset($_FILES['afileImage']))
		{
			if ($_FILES['afileImage']['error'] > 0)
			{
				switch($_FILES['afileImage']['error'])
				{
					case 2:
						echo "<script> document.getElementById('lblImgError').innerHTML='File vượt quá kích thước (2MB)'</script>";
						$imgCheck=false;
						break;
					case 4:
						echo "<script> document.getElementById('lblImageNULL').style.display='inline-block'; </script>";
						echo "<script> document.getElementById('lblNULL').style.display='block'; </script>";
						$imgCheck=false;
						break;
				}
			}
			else
				if(!preg_match('/^image\//',$_FILES['afileImage']['type']))
					{echo "<script> document.getElementById('lblImgError').innerHTML='File upload phải là file hình'</script>";$imgCheck=false;}
				elseif(!preg_match('/^image\/(jpeg|gif)$/',$_FILES['afileImage']['type']))
					{echo "<script> document.getElementById('lblImgError').innerHTML='File hình phải có dạng JPG hoặc GIF'</script>";$imgCheck=false;}
		}
		$sql="SELECT * FROM ProductType WHERE ProductTypeName='".$_POST['aslcType']."'";
		$rs = DataProvider::executeQuery($sql);
		$sql_auto_icrement = "SHOW TABLE STATUS WHERE name='Product'";
		$rs_ai=DataProvider::executeQuery($sql_auto_icrement);
		$txtProductTypeID = "";
		$auto_increment="";
		while($row=mysqli_fetch_array($rs,MYSQLI_BOTH))
			$txtProductTypeID=$row['ProductTypeID'];
		while($row=mysqli_fetch_array($rs_ai,MYSQLI_BOTH))
			$auto_increment=$row['Auto_increment'];
		if($txtProductTypeID!="")
		{
			if($imgCheck)
			{
				$imgName = "SP".$auto_increment;
				if($_FILES['afileImage']['type']=='image/jpeg')
					$imgName.= ".jpg";
				else
					$imgName.=".gif";
				$sqlAddProduct="INSERT INTO Product(ProductName,Brand, ProductTypeID, UnitPrice, Quantity,Description, imgsrc, Date) VALUES (";
				$sqlAddProduct.="'".$_POST['atxtProductName']."', ";
				$sqlAddProduct.="'".$_POST['atxtBrandName']."', ";
				$sqlAddProduct.="'".$txtProductTypeID."', ";
				$price = str_replace('.', '', $_POST['atxtPrice']); // xử lý dấu chấm
				$sqlAddProduct.="'".$price."', ";
				$sqlAddProduct.="'".$_POST['atxtQuantity']."', ";
				$sqlAddProduct.="'".$_POST['atxtDescription']."', ";
				$sqlAddProduct.="'".$imgName."', ";
				$sqlAddProduct.="NOW()";
				$sqlAddProduct.=")";
				$destination='../img/'.$imgName;
				DataProvider::executeQuery($sqlAddProduct);
				move_uploaded_file($_FILES['afileImage']['tmp_name'],$destination);
				echo "<script>alert('Thêm hàng thành công')</script>";
				echo "<script>document.location = 'adminproducts.php?slcSortBy=Date&slcSort=DESC';</script>";
				//header("Location: adminproducts.php?slcSortBy=Date&slcSort=DESC");
			}
		}
		else
		{
			// $message = $_POST['aslcType']." dành cho ".$_POST['aslcGender']." chưa có trong CSDL";
			// echo "<script> document.getElementById('lblTypeError').innerHTML='$message'</script>";
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
