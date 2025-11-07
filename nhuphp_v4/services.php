<?php
	session_start();
	include('php/sessionStart.php');

    require_once('DataProvider.php');

// Lấy thông tin người dùng nếu đã đăng nhập
$user = null;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql_user = "SELECT * FROM usr WHERE Email = '$email'";
    $result_user = DataProvider::executeQuery($sql_user);
    $user = mysqli_fetch_assoc($result_user);
}
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

        <style>
        .service-item {
            display: flex;
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .service-img {
            width: 250px;
            height: 180px;
            object-fit: cover;
            margin-right: 30px;
        }

        .service-content {
            flex: 1;
        }

        .service-title {
            font-size: 22px;
            font-weight: 600;
        }

        .service-date {
            font-size: 14px;
            color: gray;
        }

        .btn-order {
            margin: 10px 0;
        }

        .order-form {
            display: none;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }
    </style>
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
				<li class="active">Dịch vụ</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->

	<div class="section">
		<!-- container -->
		<div class="container container-service">
			<?php
            if (isset($_GET['slcService'])) {
                $serviceID = intval($_GET['slcService']);
                $sql = "SELECT * FROM service WHERE ServiceID = $serviceID";
            } else {
                $sql = "SELECT * FROM service ORDER BY Date DESC";
            }
        $result = DataProvider::executeQuery($sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
        <div class="service-item">
			<?php
				echo "<img src='img/" . htmlspecialchars($row["Imgsrc"]) . "' width='258px' height='180px' alt='" . htmlspecialchars($row["ServiceName"]) . "' class='service-img'>";
				?>            
				<div class="service-content">
                <h4 class="service-title"><?php echo $row['ServiceName']; ?></h4>
                <p class="service-date">Ngày đăng: <?php echo $row['Date']; ?></p>
				<?php if ($user): ?>
					<!-- Người dùng đã đăng nhập: Tự động gửi đơn khi bấm nút -->
					<form method="POST" action="php/submit_service_order.php">
						<input type="hidden" name="ServiceID" value="<?php echo $row['ServiceID']; ?>">
						<button type="submit" class="btn btn-success">Liên hệ đặt hàng</button>
					</form>
				<?php else: ?>
					<!-- Người chưa đăng nhập: Hiển thị form -->
					<button class="btn btn-primary btn-order" onclick="toggleForm(<?php echo $row['ServiceID']; ?>)">Liên hệ đặt hàng</button>
					<div class="order-form" id="form-<?php echo $row['ServiceID']; ?>">
						<form method="POST" action="php/submit_service_order.php">
							<input type="hidden" name="ServiceID" value="<?php echo $row['ServiceID']; ?>">
							<div class="form-group">
								<input type="email" name="Email" class="form-control" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input type="text" name="fullname" class="form-control" placeholder="Họ và tên" required>
							</div>
							<div class="form-group">
								<input type="tel" name="phone" class="form-control" placeholder="Số điện thoại" 
									value="<?php echo $user ? $user['PhoneNo'] : ''; ?>" 
									pattern="^0[0-9]{9}$" 
									title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số" 
									required>
							</div>

							<div class="form-group">
								<input type="text" name="address" class="form-control" placeholder="Địa chỉ" required>
							</div>
							<button type="submit" class="btn btn-success">Gửi yêu cầu</button>
						</form>
					</div>
				<?php endif; ?>
                <div class="order-form" id="form-<?php echo $row['ServiceID']; ?>">
                    <form method="POST" action="php/submit_service_order.php">
                        <input type="hidden" name="ServiceID" value="<?php echo $row['ServiceID']; ?>">
						 <div class="form-group">
                            <input type="text" name="Email" class="form-control" placeholder="Email" value="<?php echo $user ? $user['Email'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" value="<?php echo $user ? $user['UsrName'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $user ? $user['PhoneNo'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="address" class="form-control" placeholder="Địa chỉ" value="<?php echo $user ? $user['Address'] : ''; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>

        </div>
                    <p style="margin-top: 10px;"><?php echo nl2br($row['Description']); ?></p>

        <?php } ?>
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

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

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
    <script>
    function toggleForm(id) {
        var form = document.getElementById('form-' + id);
        form.style.display = (form.style.display === 'block') ? 'none' : 'block';
    }
    </script>
</body>

</html>
