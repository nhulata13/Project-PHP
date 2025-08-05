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
				<!-- MAIN -->
				<div id="main" class="col-md-12">
            		<h2 class="mt-4" style="padding: 15px;">Danh sách hóa đơn</h2>
					<table border=1>
						<tr>
							<td>Mã Hóa Đơn</td>
							<td>Email</td>
							<td>Tên Khi Giao</td>
							<td>SĐT Khi Giao</td>
							<td>Địa Chỉ Giao</td>
							<td>Tình trạng đơn</td>
							<td>Tình trạng thanh toán</td>
							<!-- <td>Tiền Hàng</td>
							<td>Ship</td> -->
							<td>Tổng Cộng (VNĐ)</td>
							<td></td>
						</tr>
						<?php
							require_once('../DataProvider.php');
							$sql="SELECT * FROM Invoice";
							$rs=DataProvider::executeQuery($sql);
							while($row=mysqli_fetch_array($rs,MYSQLI_BOTH))
							{
								echo "<tr>";
								echo "<form id='Invoice' name='Invoice' action='admin-invoice-details.php' method='POST'>";

								echo "<input type='hidden' name='InvoiceID' id='InvoiceID' value='".$row['InvoiceID']."'>";
								
								// Kiểm tra khiếu nại
								$sqlComplaint = "SELECT Status FROM complaint WHERE InvoiceID = '" . $row['InvoiceID'] . "'";
								$rsComplaint = DataProvider::executeQuery($sqlComplaint);
								$hasComplaint = mysqli_num_rows($rsComplaint) > 0;
								$complaintStatus = $hasComplaint ? mysqli_fetch_assoc($rsComplaint)['Status'] : null;

								// Xuất cột Mã hóa đơn + icon nếu có khiếu nại
								echo "<td>";
								echo $row['InvoiceID'];
								if ($hasComplaint) {
									$icon = $complaintStatus == 0 ? "../images/cp1.png" : "../images/cp2.png";
									echo "<img src='../img/$icon' width='20px' style='cursor:pointer;' title='Xem khiếu nại' onclick='event.stopPropagation(); openComplaint(".$row['InvoiceID'].");'>";

								}
								echo "</td>";
								echo "<td>".$row['Email']."</td>";
								echo "<td>".$row['UsrName']."</td>";
								echo "<td>".$row['PhoneNo']."</td>";
								echo "<td>".$row['Address']."</td>";
								// Status Dropdown with 4 options
								$isCancelled = ($row['Status'] == "Đơn bị Hủy");
								$style = $isCancelled ? "style='color: red; font-weight: bold;'" : "";
								$disabled = $isCancelled ? "disabled" : "";

								echo "<td><select name='status' id='status' data-invoice-id='" . $row['InvoiceID'] . "' $style $disabled>";
								$statusOptions = ["Chờ xác nhận", "Đã tiếp nhận", "Đang giao hàng", "Hoàn tất đơn hàng ", "Đơn bị Hủy"];
								
								foreach ($statusOptions as $statusOption) {
									$selected = ($row['Status'] == $statusOption) ? 'selected' : '';
									echo "<option value='$statusOption' $selected>$statusOption</option>";
								}
								echo "</select></td>";							
									
								// echo "<td>".$row['SubTotal']."</td>";
																// echo "<td>".$row['Ship']."</td>";
								echo "<td>";
								$paymentStatusOptions = [
									"0" => "Chưa thanh toán",
									"1" => "Đã thanh toán"
								];
								$isPaid = $row['Payment Status'];
								$disabled = ($isPaid == "1") ? "disabled style='color:green; font-weight:bold;'" : ""; // Khoá và đổi màu nếu đã thanh toán

								echo "<select name='payment_status' class='payment-status' data-invoice-id='" . $row['InvoiceID'] . "' $disabled>";
								foreach ($paymentStatusOptions as $value => $label) {
									$selected = ($isPaid == $value) ? "selected" : "";
									echo "<option value='$value' $selected>$label</option>";
								}
								echo "</select>";
								echo "</td>";


								echo "<td>" . number_format($row['Total'], 0, ',', '.') . "</td>";

								echo "<td><input type='submit' name='btnSubmitInvoice' id='btnSubmitInvoice' value='Xem Chi Tiết'></td>";

								echo "</form>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
	<!-- Modal hiển thị khiếu nại -->
	<div id="complaintModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; border:1px solid #ccc; padding:20px; z-index:9999; width:500px;">
		<h3 style="color: #f3312E; text-align: center;">Chi Tiết Khiếu Nại</h3>
		<p><strong>Tiêu đề:</strong> <span id="complaintTitle"></span></p>
		<p><strong>Mô tả:</strong> <span id="complaintDesc"></span></p>
		<p><strong>Ngày gửi:</strong> <span id="complaintDate"></span></p>

		<form id="adminReplyForm" method="POST" action="reply-complaint.php">
			<input type="hidden" name="ComplaintID" id="ComplaintID">
			<label for="AdminReply">Phản hồi của admin:</label><br>
			<textarea name="AdminReply" id="AdminReply" rows="4" style="width:100%"></textarea><br><br>
			<button type="submit" style="background-color: #f3312E; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-right: 10px;">
				Gửi phản hồi
			</button>

			<button type="button" onclick="closeModal()" style="background-color: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
				Đóng
			</button>
		</form>
	</div>

	

	<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>
	<script>
	// JavaScript to handle the status change and update it automatically via AJAX
	document.querySelectorAll('select[name="status"]').forEach(select => {
		select.addEventListener('change', function () {
			var invoiceID = this.getAttribute('data-invoice-id');
			var status = this.value;

			// AJAX request to update status in the database
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'update_invoice_status.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status == 200) {
					alert('Trạng thái hóa đơn đã được cập nhật!');
					location.reload(); // ⚠️ Load lại trang sau khi cập nhật thành công
				} else {
					alert('Có lỗi xảy ra khi cập nhật trạng thái!');
				}
			};
			xhr.send('InvoiceID=' + invoiceID + '&status=' + encodeURIComponent(status));
		});
	});
	function openComplaint(invoiceID) {
		fetch('get-complaint.php?invoiceID=' + invoiceID)
			.then(response => response.json())
			.then(data => {
				if (data) {
					document.getElementById('complaintTitle').innerText = data.Title;
					document.getElementById('complaintDesc').innerText = data.Description;
					document.getElementById('complaintDate').innerText = data.DateSubmitted;
					document.getElementById('AdminReply').value = data.AdminReply || '';
					document.getElementById('ComplaintID').value = data.ComplaintID;
	// Nếu status = 0 → làm trống ô phản hồi
					if (parseInt(data.Status) === 0) {
						document.getElementById('AdminReply').value = '';
					} else {
						document.getElementById('AdminReply').value = data.AdminReply || '';
					}
					document.getElementById('complaintModal').style.display = 'block';
				}
			});
	}
	function closeModal() {
		document.getElementById('complaintModal').style.display = 'none';
	}

	// Xử lý cập nhật trạng thái thanh toán
	document.querySelectorAll('select.payment-status').forEach(select => {
		select.addEventListener('change', function () {
			var invoiceID = this.getAttribute('data-invoice-id');
			var paymentStatus = this.value;

			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'update_payment_status.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status == 200) {
					alert('Trạng thái thanh toán đã được cập nhật!');
					location.reload(); // ✅ Reload sau khi cập nhật thành công
				} else {
					alert('Lỗi khi cập nhật trạng thái thanh toán!');
				}
			};
			xhr.send('InvoiceID=' + invoiceID + '&payment_status=' + paymentStatus);
		});
	});

</script>
</body>

</html>
