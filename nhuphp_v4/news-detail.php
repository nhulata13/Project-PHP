<?php
session_start();
include('php/sessionStart.php');
require_once('DataProvider.php');

// Kiểm tra nếu có truyền news_id
if (!isset($_GET['news_id']) || !is_numeric($_GET['news_id'])) {
    header("Location: news.php");
    exit();
}

$news_id = intval($_GET['news_id']);
$sql = "SELECT * FROM news WHERE NewsID = $news_id";
$result = DataProvider::executeQuery($sql);
$news = mysqli_fetch_assoc($result);

if (!$news) {
    echo "<h3>Không tìm thấy bài viết.</h3>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOÀNG PHÁT</title>

    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded|Encode+Sans+Semi+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/extrastyle.css">

    <style>
        .news-detail-container {
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .news-detail-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .news-detail-date {
            font-size: 14px;
            color: gray;
            margin-bottom: 25px;
        }

        .news-detail-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            margin-bottom: 25px;
            border-radius: 6px;
        }

        .news-detail-content {
            font-size: 16px;
            line-height: 1.8;
        }
    </style>
</head>
<body>

    <?php include('php/header.php'); ?>

        <div id="navigation">
            <div class="container">
                <div id="responsive-nav">
                    <div class="category-nav">
                        <?php include('php/category-nav.php'); ?>
                    </div>
                    <?php include('php/menu-nav.php'); ?>
                </div>
            </div>
        </div>
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li><a href="news.php">Tin tức</a></li>
                <li class="active"><?php echo htmlspecialchars($news['NewsTitle']); ?></li>
            </ul>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="news-detail-container">
                <h1 class="news-detail-title"><?php echo htmlspecialchars($news['NewsTitle']); ?></h1>
                <p class="news-detail-date">Ngày đăng: <?php echo date('d/m/Y H:i', strtotime($news['Date'])); ?></p>
                <img src="img/<?php echo htmlspecialchars($news['ImgSrc']); ?>" alt="" class="news-detail-image">
                <div class="news-detail-content">
                    <?php echo nl2br($news['Description']); ?>
                </div>
            </div>
        </div>
    </div>

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

    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
