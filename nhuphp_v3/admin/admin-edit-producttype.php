<!DOCTYPE html>
<?php
	ob_start();
?>
<?php
	include('php/sessionAdmin.php');
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
                if (isset($_POST['btnSubmit'])) {
                    $sql = "SELECT * FROM ProductType WHERE ProductTypeID = " . $_POST['etxtID'];
                    $rs = DataProvider::executeQuery($sql);
                    $row = mysqli_fetch_array($rs, MYSQLI_BOTH);
                }
            ?>

            <div id="main" class="col-md-12">
                <a href="admin-add-product-type.php" class="btn btn-primary">
                    <i class="fa fa-home"></i>
                </a>

                <form id="editProductType" name="editProductType" action="admin-add-product-type.php" method="POST" onsubmit="return checkEditProductType();">
                    <span id="lblNULL" style="color:red; display:none;">*: Chưa nhập/Chưa chọn</span>
                    <span id="lblECHAR" style="color:red; display:none;">*: Không được có ký tự lạ</span>

                    <!-- Tên loại sản phẩm -->
                    <span class="text-uppercase">Tên loại sản phẩm: </span>
                    <?php
                        echo "<input type='hidden' name='etxtID' id='etxtID' value='".$row['ProductTypeID']."'>";
                        echo "<input type='text' name='etxtProductName' id='etxtProductName' value='".$row['ProductTypeName']."'>";
                    ?>
                    <span id="lblProductNameTypeNULL" style="color:red; display:none;">*</span>
                    <br><br>

                    <!-- Danh mục -->
                    <span class="text-uppercase">Danh mục: </span>
                    <select name="eslcCategory" id="eslcCategory">
                        <?php
                            $sqlCategories = "SELECT DISTINCT Category FROM producttype";
                            $rsCategories = DataProvider::executeQuery($sqlCategories);
                            while ($categoryRow = mysqli_fetch_array($rsCategories, MYSQLI_ASSOC)) {
                                $selectedCategory = ($categoryRow['Category'] == $row['Category']) ? "selected" : "";
                                echo "<option value='".$categoryRow['Category']."' $selectedCategory>".$categoryRow['Category']."</option>";
                            }
                        ?>
                    </select>
                    <br><br>

                    <input name="btnEditProductType" type="submit" value="Sửa Loại Hàng">
                    <input type="reset" value="Làm lại">
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
