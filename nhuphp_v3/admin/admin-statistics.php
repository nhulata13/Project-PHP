<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
	include('php/sessionInvoice.php');
    require_once('../DataProvider.php');  

    // Truy vấn SQL lấy dữ liệu thống kê theo tháng
$sql = "SELECT 
MONTH(DateInvoice) AS month,
COUNT(*) AS totalOrders,
SUM(Total) AS totalRevenue
FROM 
invoice
WHERE 
YEAR(DateInvoice) = YEAR(CURDATE()) 
GROUP BY 
MONTH(DateInvoice)
ORDER BY 
MONTH(DateInvoice)";

$result = DataProvider::executeQuery($sql);

if (!$result) {
die('Lỗi truy vấn SQL: ' . mysqli_error($conn));
}

$months = [];
$totalOrders = [];
$totalRevenue = [];

while ($row = mysqli_fetch_assoc($result)) {
$months[] = 'Tháng ' . $row['month']; 
$totalOrders[] = $row['totalOrders'];
$totalRevenue[] = $row['totalRevenue'];
}

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


	<div class="section">
		
        <div class="container container-admin">
		<?php include('php/navigationInvoice.php'); ?>
			<div class="row row-admin"> 
				<h2 class="text-center">Thống Kê Doanh Thu và Số Hóa Đơn 2025</h2>

					<!-- Bảng thống kê -->
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>Tháng</th>
								<th>Tổng số hóa đơn</th>
								<th>Tổng doanh thu (VND)</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i = 0; $i < count($months); $i++) : ?>
							<tr>
								<td><?php echo $months[$i]; ?></td>
								<td><?php echo $totalOrders[$i]; ?></td>
								<td><?php echo number_format($totalRevenue[$i]); ?></td>
							</tr>
							<?php endfor; ?>
						</tbody>
					</table>

					<!-- Biểu đồ doanh thu và số hóa đơn -->
					<canvas id="revenueChart"style="width: 500px; height: 150px;"></canvas>
			</div>


            
       	 </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    
                    label: 'Tổng doanh thu (VND)',
                    data: <?php echo json_encode($totalRevenue); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    

	

	<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>

</body>

</html>
