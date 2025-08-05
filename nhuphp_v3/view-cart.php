<?php
	session_start();
	include('php/sessionStart.php');
?>

<!DOCTYPE html>
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
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />
	<link type="text/css" rel="stylesheet" href="css/extrastyle.css">
	<script src="js/extrafunction.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
	<!-- hello, logo, search, signin/up, basket -->
	<?php include('php/header.php'); ?>
	<!-- NAVIGATION -->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- category nav -->
				<div class="category-nav">
					<?php include('php/category-nav.php'); ?>
				</div>
				<!-- /category nav -->

				<?php include('php/menu-nav.php'); ?>
			</div>
		</div>
		<!-- /container -->
	</div>
	<!-- /NAVIGATION -->

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li class="active">Giỏ Hàng</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<?php
		$Count=0;
		if(isset($_SESSION['Cart']))
		foreach($_SESSION['Cart'] as $id=>$SL)
		if(isset($id)) $Count++;
	?>
	<div class="section">
		<!-- container -->
		<div class="container container-cart">
			<!-- row -->
			<div class="row">
				<?php
					
					if($Count>0)
					{
				?>
				<div class="col-md-12">
					<div class="order-summary clearfix">
						<div class="section-title">
							<h3 class="title">Giỏ Hàng</h3>
						</div>
						<table class="shopping-cart-table table">
							<?php
								if($Count>0)
								{
							?>
							<thead>
								<tr>
									<th>Hàng Hóa</th>
									<th></th>
									<th class="text-center">Số Lượng</th>
									<th class="text-center">Thành tiền</th>
									<th class="text-center">...</th>
								</tr>
							</thead>
							<?php
									require_once('DataProvider.php');
									if(isset($_SESSION['Cart']))
									{
										$Price=0;
										foreach($_SESSION['Cart'] as $id=>$SL)
										if(isset($id))
										{
											$sql="SELECT * FROM Product WHERE ProductID=$id";
											$rs=DataProvider::executeQuery($sql);
											$row=mysqli_fetch_array($rs,MYSQLI_ASSOC);
											echo "<form name='cartProducts' id='cartProducts' action='php/cart.php' method='POST'>";
											echo "<tbody>";
											echo "	<tr>";
											echo "		<td class='thumb'><img src='./img/".$row['imgsrc']."' alt=''></td>";
											echo "		<td class='details'>";
											echo "			<a href='#'>".$row['ProductName']."</a>";
											echo "			<ul>";
											echo "			</ul>";
											echo "		<div class='price text-center'><strong><script>document.write(PriceDot(".$row["UnitPrice"]."))</script></strong></div>";
											echo "		</td>";
											echo "		<td class='qty text-center'><input name='txtQuantity' class='input' type='number' min=1 value=$SL></td>";
											echo "		<td class='total text-center'><strong class='primary-color'><script>document.write(PriceDot(".$row['UnitPrice']*$SL."))</script></strong></td>";
											echo "		<td class='text-center'><button type='submit' name='btnUpdate' class='main-btn icon-btn'><i class='fa fa-refresh'></i></button><button type='submit' name='btnDel' class='main-btn icon-btn'><i class='fa fa-close'></i></button></td>";
											echo "	</tr>";
											echo "</tbody>";
											echo "<input name='txtProductID' type='hidden' value='".$row['ProductID']."' >";
											echo "<input name='txtURL' type='hidden' value=".$_SERVER['REQUEST_URI']." >";
											echo "</form>";
											$Price+=$row['UnitPrice']*$SL;
										}
									}
							?>
							<tfoot style='display:none;'>
								<tr>
									<th class="empty" colspan="3"></th>
									<th>Tổng</th>
									<?php echo "<th colspan='3' class='sub-total'><script>document.write(PriceDot(".$Price."))</script></th>" ?>
								</tr>
							</tfoot>
						</table>
						<div class="pull-right" style='display:none;'>
							<a href='checkout.php'><button type='button' class="primary-btn">Thanh Toán</button></a>
						</div>
						<?php
							}
						?>
					</div>
				</div>
				<?php
					}
					else
					{
						echo "<p>Bạn chưa mua hàng, hãy thử chọn vài món nhé</p>";
				?>
				<div class="row">
					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h2 class="title">Đề xuất cho bạn</h2>
						</div>
					</div>
					<!-- section title -->
				<?php
					$sql = "SELECT * FROM Product ORDER BY Date DESC LIMIT 0,4";
					$result = DataProvider::executeQuery($sql);
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
					{
						echo "<!-- Product Single -->";
						echo "<form name='products' id='products' action='php/cart.php' method='POST'>";
						echo "<div class='col-md-3 col-sm-6 col-xs-6'>";
						include('php/productsingle.php');
						echo "</div>";
						echo "</form>";
						echo "<!-- /Product Single -->";
					}
				?>
				</div>
				<!-- row -->
				<?php
					}
				?>
			</div>
			<!-- /row -->
			 <!-- Đơn hàng tạm tính -->
		<div class="col-md-4">
			<div class="order-summary clearfix " >
				<div class="section-title" >
					<h3 class="title">Đơn hàng</h3>
				</div>
				
				<form method="GET">
					<?php
						require_once('DataProvider.php');
						$Price = 0;
						$discount_percentage = 0; // Mặc định giảm giá là 0
						$error_message = ""; // Biến để chứa thông báo lỗi
						// Tính tổng giá trị giỏ hàng
						if (isset($_SESSION['Cart'])) {
							foreach ($_SESSION['Cart'] as $id => $quantity) {
								$sql = "SELECT * FROM Product WHERE ProductID = $id";
								$rs = DataProvider::executeQuery($sql);
								$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
								$Price += $row['UnitPrice'] * $quantity;
							}
						}
						// Kiểm tra xem người dùng có nhập mã khuyến mãi không qua GET
						if (isset($_GET['apply_promo']) && isset($_GET['promo_code'])) {
							if ($Price == 0) {
								// Nếu giá trị Price là 0, hiển thị lỗi yêu cầu người dùng thêm sản phẩm vào giỏ hàng
								$error_message = "Vui lòng chọn sản phẩm trước khi áp dụng mã giảm giá.";
								
							} else {
								$promo_code = $_GET['promo_code']; // Lấy mã giảm giá từ URL
								$sql = "SELECT * FROM voucher WHERE VoucherID = '$promo_code'";
								$rs = DataProvider::executeQuery($sql);

								if (mysqli_num_rows($rs) > 0) {
									$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
									$start_date = $row['StartDate'];
									$end_date = $row['EndDate'];
									$current_date = date('Y-m-d'); // Lấy ngày hiện tại theo định dạng 'YYYY-MM-DD'

									// Kiểm tra xem mã giảm giá có hợp lệ không (trong khoảng thời gian sử dụng)
									if ($start_date <= $current_date && $end_date >= $current_date) {
										// Mã giảm giá hợp lệ
										$discount_percentage = $row['DiscountPercent']; // Lấy phần trăm giảm giá từ cơ sở dữ liệu
									} else {
										// Nếu mã giảm giá đã hết hạn
										$discount_percentage = 0;
										$error_message = "Mã giảm giá đã hết giá trị sử dụng.";
									}
								} else {
									// Nếu không có mã giảm giá hợp lệ
									$discount_percentage = 0;
									$error_message = "Mã giảm giá không hợp lệ.";
								}

							}
						}

						// Lưu giá trị giảm giá vào session
						$_SESSION['discount_percentage'] = $discount_percentage;
					?>
					<table class="table">
						<tr>
							<td><strong>Nhập mã khuyến mãi</strong></td>
							<td class="text-right">
								<div class="promo-code-container">
									<input type="text" name="promo_code" class="form-control" placeholder="Nhập mã khuyến mãi">
									<button type="submit" name="apply_promo" class="btn btn-primary">Áp dụng</button>
								</div>
							</td>
						</tr>
						<?php if ($error_message): ?>
							<!-- Hiển thị thông báo lỗi nếu có -->
							<tr>
								<td colspan="2" class="text-center" style="color: red;">
									<small><?php echo $error_message; ?></small>
								</td>
							</tr>
						<?php endif; ?>
						<tr>
							<td><strong>Đơn hàng</strong></td>
							<td class="text-right">
								<strong><script>document.write(PriceDot(<?php echo $Price; ?>))</script></strong>
							</td>
						</tr>
							
						<tr>
							<td ><strong>Giảm giá</strong></td>
							<td class="text-right">
								<strong><?php 
									if ($Price == 0) {
										echo "0%";
									} else {
										echo $discount_percentage . "%"; 
									}
								?></strong>
							</td>
							</tr>
						<tr>
							<td><strong>Tổng tiền</strong></td>
							<td class="text-right">
							<strong id="totalAfterDiscount">
								<?php 
									if ($Price == 0) {
										echo "0 đ";
									} else {
										echo number_format($Price - ($Price * $discount_percentage / 100), 0, ',', '.') . " đ"; 
									}
								?>
							</strong>
							</td>
						</tr>
					</table>
					<div class="pull-right">
						<a href="checkout.php"><button type="button" class="primary-btn">Tiếp tục Thanh Toán</button></a>
					</div>
				</form>
			</div>
		</div>
		<!-- /Đơn hàng tạm tính -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- FOOTER -->
	<footer id="footer" class="section section-grey">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- footer widget -->
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="footer">
							<!-- footer logo -->
							<div class="footer-logo">
								<a class="logo" href="#">
						<img src="./images/logo.png" alt="">
					</a>
							</div>
							<!-- /footer logo -->

							<!-- <p>Phục vụ như mẹ của bạn</p> -->

							<!-- footer social -->
							<ul class="footer-social">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-instagram"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
							</ul>
							<!-- /footer social -->
						</div>
					</div>
					<!-- /footer widget -->

					<!-- footer widget -->
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="footer">
							<h3 class="footer-header">Chăm Sóc Khách Hàng</h3>
							<?php include('php/footer.php'); ?>
						</div>
					</div>
					<!-- /footer widget -->

					<div class="clearfix visible-sm visible-xs"></div>

					<!-- footer widget -->
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="footer">
							<h3 class="footer-header">TỔNG ĐÀI TƯ VẤN</h3>
							<p><i class="fa fa-phone-square"> Hotline: 1900 888.XXX</i></p>
							<p><i class="fa fa-phone-square"> CSKH: +1234.567.89</i></p>
							<!-- Ô nhập SĐT/Email -->
							<!-- Form nhận tư vấn -->
							<form action="#" method="post" class="consult-form">
								<div class="input-wrapper">
									<input type="text" name="contactInfo" placeholder="Nhập SĐT/Email để nhận tư vấn" class="consult-input" required>
									<button type="submit" class="send-icon-btn"><i class="fa fa-paper-plane"></i></button>
								</div>
							</form>
						</div>
					</div>
					<!-- /footer widget -->

					<!-- footer subscribe -->
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="footer">
							<h3 class="footer-header">Giới thiệu</h3>
							<p>Giới thiệu</p>
							<p>Giao hàng, lắp đặt</p>
							<p>Câu hỏi thường gặp</p>
						
						</div>
					</div>
					<!-- /footer subscribe -->
				</div>
				<!-- /row -->
				<hr>
				<!-- row -->
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center">
						<!-- footer copyright -->
						<div class="footer-copyright">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="" target="_blank">QUYNHNHU</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</div>
						<!-- /footer copyright -->
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</footer>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
<!-- JavaScript để xử lý gửi form và chuyển hướng lại -->
<script>
document.getElementById("apply_promo").addEventListener("click", function() {
    // Lấy giá trị mã giảm giá từ ô input
    var promo_code = document.getElementById("promo_code").value;

    // Kiểm tra nếu mã giảm giá không trống
    if (promo_code.trim() !== "") {
        // Tạo form động
        var form = document.getElementById("promo-form");
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "promo_code";
        input.value = promo_code;
        form.appendChild(input);

        // Gửi form qua POST mà không giữ lại tham số trong URL
        form.submit();
    }
});
</script>
</body>

</html>
