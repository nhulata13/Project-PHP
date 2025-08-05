<?php
session_start();
include('php/sessionStart.php');
require_once('DataProvider.php');

// Lấy tin tức mới nhất
$sql = "SELECT * FROM news ORDER BY Date DESC LIMIT 6";
$result = DataProvider::executeQuery($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOÀNG PHÁT | Tin tức</title>

    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded|Encode+Sans+Semi+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/extrastyle.css">
    <script src="js/extrafunction.js"></script>

    <style>
    .news-card {
        border: 1px solid #eee;
        border-radius: 6px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .news-card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .news-card-body {
        padding: 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .news-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        min-height: 48px;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-date {
        font-size: 13px;
        color: gray;
        margin-bottom: 10px;
    }

    .news-desc {
        font-size: 14px;
        margin-bottom: 15px;
        flex-grow: 1;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-read {
        font-size: 14px;
        background-color: #F3312E;
        align-self: centert;
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
                <li class="active">Tin tức</li>
            </ul>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h2 class="text-center mb-4">📰 Tin tức mới nhất</h2>
            <div class="row">
                <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="news-card">
                            <img src="img/<?php echo htmlspecialchars($row['ImgSrc']); ?>" alt="<?php echo htmlspecialchars($row['NewsTitle']); ?>">
                            <div class="news-card-body">
                                <h5 class="news-title"><?php echo htmlspecialchars($row['NewsTitle']); ?></h5>
                                <p class="news-date">Ngày đăng: <?php echo date('d/m/Y', strtotime($row['Date'])); ?></p>
                                <p class="news-desc"><?php echo nl2br(mb_substr(strip_tags($row['Description']), 0, 100)) . '...'; ?></p>
                                <a href="news-detail.php?news_id=<?php echo $row['NewsID']; ?>" class="btn btn-primary btn-read">Đọc thêm</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
