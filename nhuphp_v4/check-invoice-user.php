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
	    <link type="text/css" rel="stylesheet" href="css/bonus.css" />

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
				<li class="active">Tài khoản</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<div class="section">
		<!-- container -->
		<div class="container user">
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
						
				?>
                    <?php

                            // Lấy email của người dùng từ session
                            $email = $_SESSION['username'];
                            
                            // Truy vấn thông tin người dùng từ bảng usr
                            $sqlUser = "SELECT * FROM usr WHERE Email = '$email'";
                            $resultUser = DataProvider::executeQuery($sqlUser);
                            // Lấy thông tin người dùng
                            $user = mysqli_fetch_assoc($resultUser);
                            $userName = $user['UsrName'];
                            $phoneNo = $user['PhoneNo'];
                            $address = $user['Address'];

                            // Hiển thị thông tin người dùng
							echo '<div class="section-title">
							<h2 class="title">Thông tin tài khoản</h2>
							</div>';
							echo "<p><strong>Tên tài khoản: </strong>" . $userName . "</p>";
                            echo "<p><strong>Số điện thoại: </strong>" . $phoneNo . "</p>";
                            echo "<p><strong>Địa chỉ: </strong>" . $address . "</p>";

                            // Truy vấn các hóa đơn của người dùng
                            $sql = "SELECT * FROM invoice WHERE Email = '$email' ORDER BY DateInvoice ";
                            $result = DataProvider::executeQuery($sql);

                            if (mysqli_num_rows($result) > 0) {
                                // Nếu có hóa đơn, hiển thị danh sách
                                echo '<div class="section-title">
									<h2 class="title"> DANH SÁCH HÓA ĐƠN CỦA BẠN</h2>
									</div>';
                                echo "<table class='table'>
                                        <thead>
                                            <tr>
                                                <th>Ngày mua hàng</th>
                                                <th>Tổng tiền</th>
                                                <th>Chi tiết</th>
												<th>Tình trạng đơn hàng</th>
												<th>Khiếu nại</th>

                                            </tr>
                                        </thead>
                                        <tbody>";

                                while ($row = mysqli_fetch_assoc($result)) {

									$invoiceID = $row['InvoiceID']; // Lấy ID hóa đơn
									
									// Truy vấn để kiểm tra nếu hóa đơn này đã có khiếu nại
									$sqlComplaint = "SELECT * FROM complaint WHERE InvoiceID = $invoiceID";
									$resultComplaint = DataProvider::executeQuery($sqlComplaint);

									if (mysqli_num_rows($resultComplaint) > 0) {
										// Nếu có khiếu nại, lấy thông tin khiếu nại
										$complaint = mysqli_fetch_assoc($resultComplaint);
										$complaintID = $complaint['ComplaintID']; // Lấy ComplaintID
										$status = $complaint['Status']; // Lấy trạng thái khiếu nại
										$adminReply = $complaint['AdminReply']; // Lấy phản hồi của admin
										
										// Định nghĩa phản hồi mặc định của admin
										$defaultReply = "Kính gửi Quý khách, Cảm ơn quý khách đã liên hệ với chúng tôi. Chúng tôi rất tiếc khi nghe về sự bất tiện mà quý khách gặp phải. Chúng tôi đang tiến hành kiểm tra vấn đề của quý khách và sẽ sớm phản hồi lại với giải pháp thích hợp. Chúng tôi cam kết sẽ nỗ lực hết mình để khắc phục sự cố và mang lại trải nghiệm tốt nhất cho quý khách. Nếu quý khách có thêm bất kỳ câu hỏi hay yêu cầu nào, xin đừng ngần ngại liên hệ lại với chúng tôi. Xin chân thành cảm ơn quý khách đã thông cảm và kiên nhẫn. Trân trọng.";
										
										if ($status == 0 && ($adminReply == $defaultReply || empty($adminReply))) {
											$title = addslashes($complaint['Title']);
											$desc = addslashes($complaint['Description']);
											$reply = addslashes($complaint['AdminReply']);
											$statusVal = $complaint['Status'];

											// Tin nhắn phản hồi mặc định của admin
											$defaultReply = "Kính gửi Quý khách, Cảm ơn quý khách đã liên hệ với chúng tôi. Chúng tôi rất tiếc khi nghe về sự bất tiện mà quý khách gặp phải. Chúng tôi đang tiến hành kiểm tra vấn đề của quý khách và sẽ sớm phản hồi lại với giải pháp thích hợp. Chúng tôi cam kết sẽ nỗ lực hết mình để khắc phục sự cố và mang lại trải nghiệm tốt nhất cho quý khách. Nếu quý khách có thêm bất kỳ câu hỏi hay yêu cầu nào, xin đừng ngần ngại liên hệ lại với chúng tôi. Xin chân thành cảm ơn quý khách đã thông cảm và kiên nhẫn. Trân trọng.";

											// Nếu chưa phản hồi hoặc là phản hồi mặc định => dùng mặc định
											if (empty($reply) || $reply == $defaultReply) {
												$reply = $defaultReply;
											}

											$complaintLink = "<a href='javascript:void(0)' onclick=\"openComplaintDetail('$title', '$desc', '$statusVal', '$reply')\">"
											. ($statusVal == 0 ? "Chờ phản hồi từ Admin nhé 💁" : "Admin đã phản hồi 💬")
											. "</a>";

										} elseif ($status == 1 && $adminReply != $defaultReply) {
											$title = addslashes($complaint['Title']);
											$desc = addslashes($complaint['Description']);
											$reply = addslashes($complaint['AdminReply']);
											$statusVal = $complaint['Status'];

											$complaintLink = "<a href='javascript:void(0)' onclick=\"openComplaintDetail('$title', '$desc', '$statusVal', '$reply')\">Admin đã phản hồi 💬</a>";

										}
									} else {
										// Nếu không có khiếu nại, hiển thị đường link để tạo khiếu nại
										$complaintLink = "<a href='javascript:void(0)' onclick='openModal(" . $invoiceID . ")'>😱 Khiếu nại về đơn hàng 😱</a>";
									}
                                    $status = $row['Status'];
									$cancelBtn = "";

									// Hiển thị nút "Hủy đơn" nếu trạng thái phù hợp
									if ($status == "Chờ xác nhận" || $status == "Đã tiếp nhận") {
										$cancelBtn = " / <a href='php/cancel-invoice.php?invoiceID=" . $invoiceID . "' class='btn btn-danger btn-sm cancel-btn' onclick=\"return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');\">Hủy đơn</a>";
									}

									echo "<tr>
										<td>" . $row['DateInvoice'] . "</td>
										<td>" . $row['Total'] . " VNĐ</td>
										<td><a href='invoice-details.php?invoiceID=" . $row['InvoiceID'] . "'>Xem chi tiết 👈</a></td>
										<td>" . $status . $cancelBtn . "</td>
										<td>" . $complaintLink . "</td>
									</tr>";

                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p>Bạn chưa có hóa đơn nào.</p>";
                            }
                        
                    ?>

				<?php
					}
				?>
				<!-- Modal create complaint -->
				<div class="modal-overlay" id="complaintModal" style="display: none;">
					<div class="modal-content">
						<span class="modal-close" onclick="closeModal()">&times;</span>
						<h3>Đơn khiếu nại</h3>
						<form class="submit-complaint" action="submit-complaint.php" method="post">
							<input type="hidden" name="invoiceID" id="modalInvoiceID">
							<label for="title">Tiêu đề khiếu nại:</label>
							<input type="text" name="title" required>

							<label for="description">Mô tả khiếu nại:</label>
							<textarea name="description" rows="4" required></textarea>

							<input type="submit" value="Gửi khiếu nại">
						</form>
					</div>
				</div>

				<!-- Modal complaint detail -->
				<div class="modal-overlay" id="complaintDetailModal" style="display: none;">
					<div class="modal-content">
						<span class="modal-close" onclick="closeComplaintDetail()">&times;</span>
						<h3>Chi tiết khiếu nại</h3>

						<p><strong>Tiêu đề:</strong> <span id="detailTitle"></span></p>
						<p><strong>Mô tả:</strong> <span id="detailDescription"></span></p>
						<p><strong>Trạng thái:</strong> <span id="detailStatus" class="status-label"></span></p>
						<p><strong>Phản hồi từ Admin:</strong> <span id="detailReply"></span></p>
					</div>
				</div>

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
	<script>
		function openModal(invoiceID) {
			document.getElementById('modalInvoiceID').value = invoiceID;
			document.getElementById('complaintModal').style.display = 'flex';
		}

		function closeModal() {
			document.getElementById('complaintModal').style.display = 'none';
		}

		// Đóng modal khi click ra ngoài nội dung
		window.addEventListener('click', function (e) {
			const modal = document.getElementById('complaintModal');
			if (e.target === modal) {
				closeModal();
			}
		});

		function openComplaintDetail(title, description, status, reply) {
		document.getElementById('detailTitle').innerText = title;
		document.getElementById('detailDescription').innerText = description;
		const statusEl = document.getElementById('detailStatus');

		if (status == 1) {
			statusEl.innerText = 'Đã xử lý';
			statusEl.className = 'status-done';
		} else {
			statusEl.innerText = 'Chưa xử lý';
			statusEl.className = 'status-pending';
		}
		document.getElementById('detailReply').innerText = reply || 'Chưa có phản hồi';

		document.getElementById('complaintDetailModal').style.display = 'flex';
		}

		function closeComplaintDetail() {
			document.getElementById('complaintDetailModal').style.display = 'none';
		}

		// Đóng modal khi click ra ngoài nội dung
		window.addEventListener('click', function (e) {
			const modal = document.getElementById('complaintDetailModal');
			if (e.target === modal) {
				closeComplaintDetail();
			}
		});
	</script>


</body>

</html>
