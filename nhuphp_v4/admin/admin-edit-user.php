<!DOCTYPE html>
<?php
	ob_start();
?>
<?php
	include('php/sessionAdmin.php');
	include('php/sessionUsr.php');
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


	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container container-admin">
			<!-- row -->
			<?php include('php/navigationUsr.php') ?>

			<div class="row row-admin">
				<!-- MAIN -->
				<?php
					require_once('../DataProvider.php');
					if(isset($_POST['btnUserSubmit']))
					{
						$sql="SELECT * FROM Usr INNER JOIN AuthenticationUsr WHERE Usr.Authentication=AuthenticationUsr.Authentication AND Email='".$_POST['txtEmail']."'";
						$rs = DataProvider::executeQuery($sql);
						$row = mysqli_fetch_array($rs,MYSQLI_BOTH);
					}
				?>
				
				<div id="main" class="col-md-12">
				<a href="admin-add-usr.php" class="btn btn-primary"> <i class="fa fa-home"></i></a> <!-- Change 'index.php' to your homepage URL -->
					<form id='editUser' name='editUser' action='admin-add-usr.php' method='POST' onsubmit='return true'>
						<span id='lblNULL' style='color:red; display:none;'>*: Chưa nhập/Chưa chọn</span>
						<span class='text-uppercase'>Email: </span>
						<?php
							echo "<input type='hidden' name='txtEmail' id='txtEmail' value='".$row['Email']."'>";
							echo "<span>".$row['Email']."</span>";
						?>
						<br><br>

						<span class='text-uppercase'>Họ tên: </span>
						<?php
							echo "<input type='text' name='txtUsrName' id='txtUsrName' value='".$row['UsrName']."'>";
						?>
						<br><br>

						<span class='text-uppercase'>Điện thoại: </span>
						<?php
							echo "<input type='text' name='txtPhoneNo' id='txtPhoneNo' value='".$row['PhoneNo']."'>";
						?>
						<br><br>

						<span class='text-uppercase'>Địa Chỉ: </span>
						<?php
							echo "<input type='text' name='txtAddress' id='txtAddress' style='width:50%;' value='".$row['Address']."'>";
						?>
						<br><br>

						<span class='text-uppercase'>Trạng Thái: </span>
						<select name="slcBlocked" id='slcBlocked'>
						<?php
							$blocked=array("Bình Thường","Bị Khóa");
							$BlockedDB=$row['Blocked'];
							if($BlockedDB==0)
								$BlockedDB="Bình Thường";
							else
								$BlockedDB="Bị Khóa";
							$i=0;
							foreach ($blocked as $Blocked)
							if($BlockedDB==$Blocked)
								{echo "<option value='$i' selected>$Blocked</option>"; $i++;}
							else
								{echo "<option value='$i'>$Blocked</option>"; $i++;}
						?>
						</select>
						<br><br>

						<span class='text-uppercase'>Quyền: </span>
						<select name="slcAuthentication" id='slcAuthentication'>
						<?php
							$sql="SELECT * FROM AuthenticationUsr";
							$rs = DataProvider::executeQuery($sql);
							$Auth=$row['Authentication'];
							while($rowAuth=mysqli_fetch_array($rs,MYSQLI_BOTH))
							{
								$rowAuthentication=$rowAuth['Authentication'];
								if($Auth==$rowAuthentication)
									echo "<option value='$rowAuthentication' selected>".$rowAuth['AuthenticationName']."</option>";
								else
									echo "<option value='$rowAuthentication'>".$rowAuth['AuthenticationName']."</option>";
							}
						?>
						</select>
						<br><br>

						<input name='btnEditUsr' type='submit' value='Sửa User'>
						<input type='reset' value='Làm lại'>
					</form>
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	

	<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>

</body>

</html>
