<?php
session_start();
require_once('../DataProvider.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OrderID'], $_POST['Status'])) {
    $orderID = intval($_POST['OrderID']);
    $status = $_POST['Status'];

    $updateSql = "UPDATE orders SET Status = '$status' WHERE OrderID = $orderID";
    DataProvider::executeQuery($updateSql);
    echo "<script>alert('Cập nhật trạng thái thành công'); window.location.href = 'admin_orders.php';</script>";
    exit();
}

$sql = "SELECT o.*, s.ServiceName FROM orders o
        JOIN service s ON o.ServiceID = s.ServiceID
        ORDER BY o.OrderDate DESC";
$result = DataProvider::executeQuery($sql);
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
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
		<!-- container -->
	</header>
	<!-- /HEADER -->
     <div class="section">
		<!-- container -->
		<div class="container container-admin">
		    <?php include('php/navigationUsr.php') ?>
            <div class="row row-admin" style="padding: 15px;">
            <h2 class="mt-4" style="padding: 15px;">Danh sách yêu cầu dịch vụ</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Họ tên</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Dịch vụ</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['OrderID'] ?></td>
                        <td><?= htmlspecialchars($row['Email']) ?></td>
                        <td><?= htmlspecialchars($row['UsrName']) ?></td>
                        <td><?= htmlspecialchars($row['PhoneNo']) ?></td>
                        <td><?= htmlspecialchars($row['Address']) ?></td>
                        <td><?= htmlspecialchars($row['ServiceName']) ?></td>
                        <td><?= $row['OrderDate'] ?></td>
                        <td>
                            <?php if ($row['Status'] === 'Đã hoàn thành'): ?>
                                <strong style="color: green;">Đã hoàn thành</strong>
                            <?php elseif ($row['Status'] === 'Đã huỷ'): ?>
                                <strong style="color: red;">Đã huỷ</strong>
                            <?php else: ?>
                                <form method="POST" class="form-inline">
                                    <input type="hidden" name="OrderID" value="<?= $row['OrderID'] ?>">
                                    <select name="Status" class="form-control" required>
                                        <option value="Chờ xử lý" <?= $row['Status'] === 'Chờ xử lý' ? 'selected' : '' ?>>Chờ xử lý</option>
                                        <option value="Đã liên hệ" <?= $row['Status'] === 'Đã liên hệ' ? 'selected' : '' ?>>Đã liên hệ</option>
                                        <option value="Đã hoàn thành">Đã hoàn thành</option>
                                        <option value="Đã huỷ">Đã huỷ</option>
                                    </select>
                        </td>
                        <td>
                                    <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

            </div>
        </div>
    </div>
<!-- jQuery Plugins -->
<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>
    <script src="../js/extrafunction.js"></script>

    </body>
    </html>

</body>
</html>
