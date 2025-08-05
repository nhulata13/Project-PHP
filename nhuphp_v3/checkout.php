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
	<?php include('php/header.php'); ?>

	<!-- NAVIGATION -->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
			<!-- category nav -->
			<div class="category-nav show-on-click">
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
				<li class="active">Thanh Toán</li>
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
		<div class="container">
			<!-- row -->
			<div class="row">
				<?php
					if($_SESSION['isLogin']==0)
					{
				?>
				<p>Bạn chưa đăng nhập, nhấp vào <a href='signin.php'>ĐÂY</a> để đăng nhập hoặc tạo tài khoản mới</p>
				<?php
					}
					else
					{
						if($Count>0)
						{
				?>
				<form id="checkoutForm" name='checkoutForm' class="clearfix" method='POST' action='php/checkOut.php'>
					<div class="col-md-6">
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Thông tin thanh toán</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="txtUsrName" placeholder="Tên Người Dùng">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="txtAddress" placeholder="Địa Chỉ">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="txtPhoneNo" placeholder="Số Điện Thoại">
							</div>
							<p class='text-uppercase'>Nếu để trống sẽ lấy thông tin mặc định khi đăng ký</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="shiping-methods">
							<div class="section-title">
								<h4 class="title">Phương Thức giao hàng</h4>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="shipping" id="shipping-1" value='0' onchange='switchShipping();' checked>
								<label for="shipping-1">Giao Hàng Ngoại Thành - 50.000<sup>₫</sup></label>
								<div class="caption">
									<p>Hàng sẽ giao trong vòng 24h
										<p>
								</div>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="shipping" id="shipping-2" value='1' onchange='switchShipping();'>
								<label for="shipping-2">Giao Hàng Nội Thành - 0<sup>₫</sup></label>
								<div class="caption">
									<p>Hàng sẽ giao trong vòng 4-7 ngày
										<p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="s">
							<div class="section-title">
								<h4 class="title">Phương thức Thanh Toán</h4>
							</div>
									<div class="input-checkbox">
										<input type="radio" name="paymentMethod" id="cash" value="cash" checked>
										<label for="cash">Thanh Toán Tiền Mặt 💲 <span style="color: grey; font-weight:100"></span></label>
									</div>								
									<div class="input-checkbox">
										<input type="radio" name="paymentMethod" id="qr" value="qr">
										<label for="qr">Thanh Toán bằng Mã QR 📱</label>
										<div class="caption" id="qr-section" style="display: none; margin-top: 15px; text-align: center;">
											<p><strong>Quét mã để thanh toán:</strong></p>
											<img id="qrImage" src="" alt="QR Code" style="max-width:50%; border: 1px solid #ccc; padding: 5px;">
											<p style="display: none;"><strong>Số tiền:</strong> <span id="qrAmount"></span>₫</p>
											<p style="display: none;"><strong>Nội dung chuyển khoản:</strong> <span id="qrInfo">CHUYENHANH</span></p>

										</div>
									</div>
						</div>
					</div>
					<table class="shopping-cart-table table">
						<thead>
							<tr>
								<th>Hàng Hóa</th>
								<th></th>
								<th class="text-center">Giá</th>
								<th class="text-center">Số Lượng</th>
								<th class="text-center">Thành tiền</th>
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
										echo "<tbody>";
										echo "	<tr>";
										echo "		<td class='thumb'><img src='./img/".$row['imgsrc']."' alt=''></td>";
										echo "		<td class='details'>";
										echo "			<a href='#'>".$row['ProductName']."</a>";
										echo "			<ul>";
										echo "			</ul>";
										echo "		</td>";
										echo "		<td class='price text-center'><strong><script>document.write(PriceDot(".$row["UnitPrice"]."))</script></strong></td>";
										echo "		<td class='qty text-center'>$SL</td>";
										echo "		<td class='total text-center'><strong class='primary-color'><script>document.write(PriceDot(".$row['UnitPrice']*$SL."))</script></strong></td>";
										echo "	</tr>";
										echo "</tbody>";
										$Price+=$row['UnitPrice']*$SL;
									}
								}
						?>
						<tfoot>
							<?php

							// Lấy giá trị giảm giá từ session
							$discount_percentage = isset($_SESSION['discount_percentage']) ? $_SESSION['discount_percentage'] : 0;
							$discount_amount = isset($_SESSION['discount_amount']) ? $_SESSION['discount_amount'] : 0;

							// Tính tổng tiền sau giảm giá
							$total_after_discount = $Price - $discount_amount;
							?>
							<tr>
								<th class="empty" colspan="3"></th>
								<th>Tổng Tiền Hàng</th>
								<?php echo "<th class='sub-total'><script>document.write(PriceDot(".$Price."))</script></th>" ?>
								<?php echo "<input type='hidden' name='subTotal' id='subTotal' value='$Price'>"; ?>
							</tr>
							<tr>
								<th class="empty" colspan="3"></th>
								<th>Giảm Giá</th>
								<th class='discount'>
									<strong id="discountAmount" ><?php echo $discount_percentage . "%"; ?></strong>
									<?php
									// Gán giá trị giảm giá đã tính toán vào thẻ input
									echo "<input type='hidden' name='Discount' id='Discount' value='$discount_amount'>";
									?>
								</th>
							</tr>
							<tr>
								<th class="empty" colspan="3"></th>
								<th>Ship</th>
								<th id='lblShip'></th>
							</tr>
							<tr>
								<th class="empty" colspan="3"></th>
								<th>Tổng cộng</th>
								<th class='total' id='lblTotal'></th>
							</tr>
						</tfoot>
					</table>
					<div class="pull-right">
						<a href='view-cart.php'><button type='button' class="primary-btn">Sửa hàng</button></a>
						<button type='submit' name='btnCheckOut' class="primary-btn">Thanh Toán</button>
					</div>
				</form>
				<?php
						}
						else
						{
							echo "<p>Bạn chưa mua hàng, hãy thử chọn vài món nhé</p>";
						}
					}
				?>
			</div>
			<!-- /row -->
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
</body>

</html>
