<?php
require_once('../DataProvider.php');

// Xử lý cập nhật trạng thái sản phẩm "Hot"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hot_products'])) {
        $selectedProducts = $_POST['hot_products']; // Các sản phẩm được chọn
        
        // Đặt tất cả isTrending = 0 cho tất cả sản phẩm
        $resetQuery = "UPDATE product SET isTrending = 0";
        DataProvider::executeQuery($resetQuery);
        
        // Đặt isTrending = 1 cho các sản phẩm được chọn
        foreach ($selectedProducts as $productID) {
            $updateQuery = "UPDATE product SET isTrending = 1 WHERE ProductID = $productID";
            DataProvider::executeQuery($updateQuery);
        }
    } else {
        // Nếu không có sản phẩm nào được chọn thì đặt tất cả isTrending = 0
        $resetQuery = "UPDATE product SET isTrending = 0";
        DataProvider::executeQuery($resetQuery);
    }
}

// Lấy danh sách sản phẩm
$sql = "SELECT ProductID, ProductName, Brand, imgsrc, isTrending FROM product";
$result = DataProvider::executeQuery($sql);
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
	include('php/sessionStore.php');
?>
<html lang="vi">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>TIPO STORE</title>

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
		<?php include('php/navigationProduct.php'); ?>

			<!-- row -->
			<div class="row row-admin">
				<!-- MAIN -->
				<div id="main" class="col-md-9">

					<!-- MANAGE-PD HOT -->
                    <form method="POST" action="">
                    <div class="text-center">
                        <table class="table table-bordered table-striped">
                        <h1 class="text-center">Quản lý sản phẩm hot</h1>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>

                            <thead class="table-dark">
                                <tr>
                                    <th>Chọn "Hot"</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Thương hiệu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                    <td>
                                            <input type="checkbox" name="hot_products[]" value="<?= $product['ProductID']; ?>" 
                                            <?= $product['isTrending'] ? 'checked' : ''; ?>>
                                    </td>
                                    <td><img src='../img/<?php echo $product['imgsrc']; ?>' alt="Product Image" width="100px"></td>
                                        
                                        <td><?= $product['ProductName']; ?></td>
                                        <td><?= $product['Brand']; ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </form>
					<!-- MANAGE-PD HOT -->
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
