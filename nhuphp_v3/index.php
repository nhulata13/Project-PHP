<?php
	session_start();
	// quản lý phiên đang nhập
	if(isset($_POST['btnLogOut']) || isset($_GET['logout'])==1)
	{
		session_destroy();
		$_SESSION['isLogin']=0;
		$_SESSION['Cart']="";
		header("Location: index.php");
	}
	include('php/sessionStart.php');
	if($_SESSION['isLogin']==1)
		if($_SESSION['Authentication']!='Usr')
		{
			echo "<script>alert('Bạn không có quyền trong user');</script>";
			header('Location: admin');
        }


	require_once('DataProvider.php');
	$sqlNews = "SELECT NewsID, NewsTitle, ImgSrc, Date FROM news ORDER BY NewsID DESC LIMIT 3";
	$rsNews = DataProvider::executeQuery($sqlNews);

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
	<link type="text/css" rel="stylesheet" href="css\style.css" />
	<script src='js/extrafunction.js'></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>


	<!-- hello, logo, search, signin/up, basket -->
	<section class="fullscreen-section" id="home-section">
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
		<!-- HOME -->
		<div id="home">
				<!-- container -->
				<div class="container-home">
					
					<!-- home wrap -->
					<div class="home-wrap">
						<!-- home slick -->
						<div id="home-slick">
							<!-- banner -->
							<div class="banner banner-1">
								<img src="./images/Banner/banner01.jpg" alt="">
							</div>
							<!-- /banner -->

							<!-- banner -->
							<div class="banner banner-1">
								<img src="./images/Banner/banner02.jpg" alt="">
							</div>
							<!-- /banner -->

							<!-- banner -->
							<div class="banner banner-1">
								<img src="./images/Banner/banner03.jpg" alt="">
							</div>
							<!-- /banner -->

							<!-- banner -->
							<div class="banner banner-1">
								<img src="./images/Banner/banner04.jpg" alt="">
							</div>
							<!-- /banner -->
						</div>
						<!-- /home slick -->
					</div>
					<!-- /home wrap -->
					
				</div>
				<!-- /container -->
		</div>
		<!-- /HOME -->
	</section>

	<!-- ABOUT -->
	<section class="fullscreen-section" id="aboutct-section" >
		<!-- section -->
		<div class="section section-index">
			<section id="about">
			<div class="about-container">
				<div class="about-image">
				<img src="./images/Banner/banner-about.jpg" alt="Giới thiệu Hoàng Phát" />
				</div>
				<div class="about-content">
				<h2>VỀ HOÀNG PHÁT</h2>
				<h3>Thương Hiệu Xây Dựng Uy Tín Hàng Đầu</h3>
				<p>
					Với nhiều năm kinh nghiệm trong lĩnh vực <strong>vật liệu xây dựng</strong>,
					Hoàng Phát cam kết mang đến giải pháp tối ưu, sản phẩm chất lượng cao,
					giá thành hợp lý, góp phần vào sự phát triển bền vững cho mọi công trình Việt.
				</p>
				<div class="about-stats">
					<div class="stat-box">
					<div class="stat-number">20+</div>
					<div class="stat-label">Năm kinh nghiệm</div>
					</div>
					<div class="stat-box">
					<div class="stat-number">50,000+</div>
					<div class="stat-label">Tấn vật liệu cung ứng</div>
					</div>
					<div class="stat-box highlight">
					<div class="stat-number">1000+</div>
					<div class="stat-label">Dự án hoàn thành</div>
					</div>
				</div>
				<a href="#!" class="about-btn">Xem thêm</a>
				</div>
			</div>
			</section>
	</section>

	<!-- NEWS & BRAND -->
		<section class="fullscreen-section" id="News&Brand-section" >
			<!-- section -->
			<div class="section section-index">
				<section class="news-wrapper">
				<div class="news-container">
					<!-- Cột trái -->
					<div class="news-left">
					<h2>TIN TỨC</h2>
					<p class="subtitle">Cập nhật tin tức ngành xây dựng, kiến thức trang trí nhà cửa.</p>
					<a href="#" class="btn-view-all">XEM THÊM <span>›</span></a>
					</div>

					<div class="news-right">
						<?php while ($row = mysqli_fetch_array($rsNews, MYSQLI_ASSOC)) {
							$date = strtotime($row['Date']);
							$day = date('d', $date);
							$month = 'Th' . date('n', $date); // Ví dụ: Th9
						?>
							<div class="news-card">
								<div class="date-box">
									<span><?php echo $day; ?></span><br><?php echo $month; ?>
								</div>
								<img src="img/<?php echo htmlspecialchars($row['ImgSrc']); ?>" alt="<?php echo htmlspecialchars($row['NewsTitle']); ?>">
								<h3><?php echo htmlspecialchars($row['NewsTitle']); ?></h3>
								<a href="news-detail.php?news_id=<?php echo $row['NewsID']; ?>" class="btn-detail">XEM CHI TIẾT</a>
							</div>
						<?php } ?>
					</div>

				</div>
				</section>

				<section class="brand-wrapper">
				<div class="brand-container">
					<div class="brand-left">
					<h2>THƯƠNG HIỆU NỔI BẬT</h2>
					<p>Thương hiệu uy tín được nhiều khách hàng lựa chọn</p>
					</div>
					<div class="brand-logos">
					<img src="./images/test1.png" alt="TOTO" />
					<img src="./images/test2.png" alt="Caesar" />
					<img src="./images/test3.jpg" alt="INAX" />
					<img src="./images/test5.jpeg" alt="COTTO" />
					</div>
				</div>
				</section>
			</section>
		</section>

	<!-- PRODUCTS -->
	<section class="fullscreen-section" id="product-section" >
		<!-- section -->
		<div class="section section-index" style="box-shadow:0 20px 30px rgba(0, 0, 0, 0.08);">
			<!-- container -->
			<div class="container" >
				<!-- row -->
				<div class="row">
					
					<div class="col-md-12">
						<div class="section-title">
							<h2 class="title"> Sản phẩm nổi bật </h2>
						</div>
					</div>
					<!-- section title -->
					<?php
						$sql = "SELECT * FROM Product WHERE Doanh_so > 5 && block = 0  ORDER BY Doanh_so DESC LIMIT 0,4";
						$result = DataProvider::executeQuery($sql);
						while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
						{
							echo "<!-- Product Single -->";
							echo "<form name='products' id='products' action='php/cart.php' method='POST'>";
							echo "<div class='col-md-3 col-sm-6 col-xs-6'>";
							echo "<div class='new-label'>Hot</div>";
							include('php/productsingle.php');
							echo "</div>";
							echo "</form>";
							echo "<!-- /Product Single -->";
						}
					?>

					
				</div>
				<!-- row -->
			</div>
			<!-- /container -->
		</div>
	</section>

	<!-- ABOUT MORE -->
	<section class="fullscreen-section" id="about-section">
	<!-- About Us -->
	<div class="container-about">
    	<!-- Phần bên trái -->
		<div class="left">
		<img src="./images/nena.gif" alt="Product Intro">
		</div>

		<!-- Phần bên phải -->
		<div class="right">
			<!-- Title -->
			<div class="title" >
				<h2>Xi Măng Xây Dựng</h2>
				<p>Khám phá các dòng xi măng chất lượng cao phù hợp cho mọi công trình – từ nhà ở dân dụng đến dự án quy mô lớn. Đảm bảo độ bền chắc, tiết kiệm chi phí và tối ưu hiệu quả thi công.</p>
			</div>

			<!-- Sản phẩm -->
			<div class="products">
				<!-- Button Previous -->
				<button class="prev-btn">&lt;</button>
				<!-- Product Items -->
				<div class="product-list">
					<?php
					$sql = "SELECT * FROM Product p 
							JOIN ProductType pt ON p.ProductTypeID = pt.ProductTypeID 
							WHERE pt.ProductTypeName = 'Xi măng' AND p.block = 0";

					$result = DataProvider::executeQuery($sql);

					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						echo "<!-- Product Single -->";
								echo "<form name='products' id='products' action='php/cart.php' method='POST'>";
								echo "<div class='product product-single'>";
								echo "<div class='product-thumb'>";
								echo "<a href='product-page.php?productid=".$row['ProductID']."'><button type='button' class='main-btn quick-view'><i class='fa fa-search-plus'></i> Chi tiết</button></a>";
								echo "<img src='./img/".$row["imgsrc"]."' width='258px' height='344px' alt='".$row["ProductName"]."'>";
								echo "</div>";
								echo "<div class='product-body'>";
								echo "<div class='product-btns'>";
								echo "<input name='txtProductID' type='hidden' value='".$row['ProductID']."' >";
								echo "<input name='txtQuantity' type='hidden' value=1 >";
								echo "<input name='txtURL' type='hidden' value=".$_SERVER['REQUEST_URI']." >";						
								if ($row['Quantity'] > 0) {
									echo "<input name='btnAddToCart' type='submit' class='primary-btn add-to-cart' value='Thêm vào giỏ hàng' >";
								} else {
									echo "<span class='text-danger' style='font-weight:bold;'>Hết hàng</span>";
								}
								echo "</div>";
								echo "</div>";
								echo "</div>";								
								echo "</form>";
								echo "<!-- /Product Single -->";
					}
					
					?>
					
				</div>
				<button class="next-btn">&gt;</button>
				<!-- Button Next -->
			</div>
		</div>
    </div>

	<!-- Member Benefits Section -->
	<div class="member-benefits">
    	<h2><span>Những Cam kết với khách hàng</span></h2>
		<p> Hoàng Phát cam kết mang đến cho khách hàng những trải nghiệm dịch vụ xuất sắc thông qua sáu nguyên tắc cốt lõi<p>
		<div class="benefits-container">
			<!-- First Row -->
			<div class="benefit-item">
				<img src="./images/Banner/icon1.png" alt="Icon 1">
				<h3>Không Bán Thầu</h3>
			</div>
			<div class="benefit-item">
				<img src="./images/Banner/icon2.png"alt="Icon 2">
				<h3>Không Phát Sinh</h3>
			</div>
			<div class="benefit-item">
				<img src="./images/Banner/icon3.png" alt="Icon 3">
				<h3>Đầy Đủ Pháp Lý</h3>
			</div>
			<div class="benefit-item">
				<img src="./images/Banner/icon4.png" alt="Icon 4">
				<h3>Vật Tư Chính Hãng</h3>
			</div>
			<div class="benefit-item">
				<img src="./images/Banner/icon5.png" alt="Icon 5">
				<h3>Tuân Thủ Hợp Đồng</h3>
			</div>
			<div class="benefit-item">
				<img src="./images/Banner/icon6.png" alt="Icon 6">
				<h3>Minh Bạch Về Giá</h3>
			</div>
		</div>
	</div>
	<!-- /Member Benefits Section -->
	</section>


	<section class="fullscreen-section" id="footer-section" >
		<!-- /section -->
		<section class="testimonial-section">
			<h2 class="section-title">ĐÁNH GIÁ TỪ KHÁCH HÀNG</h2>
			<div class="testimonial-container">
				<!-- Feedback 1 -->
				<div class="testimonial-card">
					<img src="./images/pp1.jpg" alt="Khách hàng 1" class="testimonial-avatar">
					<div class="testimonial-stars">★★★★★</div>
					<p class="testimonial-text">“Hệ thống mua hàng linh hoạt, đội ngũ chăm sóc khách hàng tận tình, tích cực và tận tụy với công việc.”</p>
					<p class="testimonial-author"><strong>Anh Hiếu</strong> / Lào Cai</p>
				</div>

				<!-- Feedback 2 -->
				<div class="testimonial-card">
					<img src="./images/pp2.png" alt="Khách hàng 2" class="testimonial-avatar">
					<div class="testimonial-stars">★★★★★</div>
					<p class="testimonial-text">“Tiết kiệm thời gian và nguồn lực, linh hoạt và hiệu quả, tiện dụng, đội ngũ bán hàng hỗ trợ nhiệt tình. VLXDgiatot xứng đáng là nơi tin cậy cho bạn.”</p>
					<p class="testimonial-author"><strong>Anh Minh</strong> / Đà Nẵng</p>
				</div>

				<!-- Feedback 3 -->
				<div class="testimonial-card">
					<img src="./images/pp3.jpg" alt="Khách hàng 3" class="testimonial-avatar">
					<div class="testimonial-stars">★★★★★</div>
					<p class="testimonial-text">“Với nhiều sản phẩm phong phú và nhiều thương hiệu nổi tiếng, chúng tôi đã có sự lựa chọn đúng đắn cho ngôi nhà của mình.”</p>
					<p class="testimonial-author"><strong>Anh Tiến</strong> / Phú Quốc, Kiên Giang</p>
				</div>
			</div>
		</section>

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
	<!-- <div class="img-deco">
		<img src="./images/nenc.png" alt="Decoration Image">
	</div> -->
	</section>

	
	<br><br>


	

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
  const nextBtn = document.querySelector('.next-btn');
  const prevBtn = document.querySelector('.prev-btn');
  const productList = document.querySelector('.product-list');
  let currentIndex = 0; // Vị trí sản phẩm hiện tại

  const products = document.querySelectorAll('.product-list form');
  const productsPerPage = 2; // Số sản phẩm muốn hiển thị mỗi lần

  // Hàm cập nhật sản phẩm hiển thị
  function updateProductDisplay() {
    // Ẩn tất cả sản phẩm
    products.forEach((product, index) => {
      if (index < currentIndex || index >= currentIndex + productsPerPage) {
        product.style.display = 'none';
      } else {
        product.style.display = 'inline-block';
      }
    });
	
  }

  // Hiển thị các sản phẩm khi tải trang
  updateProductDisplay();

  // Sự kiện cho nút "Next"
  nextBtn.addEventListener('click', function () {
    if (currentIndex + productsPerPage < products.length) {
      currentIndex += productsPerPage; // Di chuyển đến các sản phẩm tiếp theo
      updateProductDisplay(); // Cập nhật hiển thị
    }
  });

  // Sự kiện cho nút "Prev"
  prevBtn.addEventListener('click', function () {
    if (currentIndex - productsPerPage >= 0) {
      currentIndex -= productsPerPage; // Di chuyển về các sản phẩm trước đó
      updateProductDisplay(); // Cập nhật hiển thị
    }
  });
});

</script>

</body>

</html>
