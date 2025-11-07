<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
	include('php/sessionUsr.php');
?>
<html lang="vi">
<?php
	ob_start();
?>

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


	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container container-admin">
		<?php include('php/navigationUsr.php') ?>
			<!-- row 1-->
			<div class="row row-admin">
				<div class="filter-options">
					<?php
							 require_once('../DataProvider.php');

							 // Lấy các giá trị `Authentication` duy nhất
							 $sql = "SELECT DISTINCT Authentication FROM usr";
							 $rs = DataProvider::executeQuery($sql);
					 
							 // Hiển thị các giá trị trong danh sách
							 echo "<div class='authentication-filter'>";
							 echo "<label><input type='radio' name='filter' value='all' onclick='filterUsers(\"all\")' checked> Tất cả</label>";
							 while ($row = mysqli_fetch_assoc($rs)) {
								 $auth = $row['Authentication'];
								 echo "<label><input type='radio' name='filter' value='$auth' onclick='filterUsers(\"$auth\")'> $auth</label>";
							 }
							 echo "</div>";
					?>
				</div>

				<!-- MAIN -->
				<div id="main" class="col-md-12">
					<?php
						require_once('../DataProvider.php');
						if(isset($_POST['btnEditUsr']))
						{
							$sql="UPDATE Usr SET 
												UsrName='".$_POST['txtUsrName']."',
												PhoneNo='".$_POST['txtPhoneNo']."',
												Address='".$_POST['txtAddress']."',
												Blocked='".$_POST['slcBlocked']."',
												Authentication='".$_POST['slcAuthentication']."'
								WHERE Email='".$_POST['txtEmail']."'";
							DataProvider::executeQuery($sql);
							echo "<script>alert('Đã sửa thành công');</script>";

							
                        }
					?>
					<?php
						require_once('../DataProvider.php');

						if (isset($_POST['btnDeleteUsr'])) {
							if (isset($_POST['emailToDelete']) && !empty($_POST['emailToDelete'])) {
								$emailToDelete = $_POST['emailToDelete'];

								$sql = "DELETE FROM Usr WHERE Email = '$emailToDelete'";

								if (DataProvider::executeQuery($sql)) {
									echo "<script>alert('Tài khoản đã bị xóa thành công!'); window.location.href = 'admin-add-usr.php';</script>";
								} else {
									echo "<script>alert('Có lỗi xảy ra khi xóa tài khoản.');</script>";
								}
							} else {
								echo "<script>alert('Không có tài khoản để xóa.');</script>";
							}
						}
					?>

					<h3>DANH SÁCH TÀI KHOẢN</h3>

					<!-- hiển thị bảng -->
					<table border=1>
						<span id='lblNULL' name='lblNULL' style='color:red; display:none'>*: Chưa nhập/Chưa chọn</span>
						<tr>
							<td>Email</td>
							<td>Tên người dùng</td>
                            <td>Số điện thoại</td>
                            <td>Địa chỉ</td>
                            <td>Blocked</td>
                            <td>Quyền</td>
							<td></td>
							        <td></td> <!-- For the delete button -->

						</tr>
						<?php
							require_once('../DataProvider.php');
							$sql="SELECT * FROM Usr";
							$rs=DataProvider::executeQuery($sql);
							while($row=mysqli_fetch_array($rs,MYSQLI_BOTH))
							{
								echo "<tr>";
                                echo "<form id='editUsr' name='editUsr' action='admin-edit-user.php' method='POST'>";
                                
								echo "<td id='txtEmailUsr' name='txtEmailUsr'>".$row['Email']."</td>";

								echo "<td id='txtUsrname' name='txtUsrname'>".$row['UsrName']."</td>";

                                echo "<td id='txtPhone' name='txtPhone'>".$row['PhoneNo']."</td>";
                                
                                echo "<td id='txtAddress' name='txtAddress'>".$row['Address']."</td>";

                                echo "<td id='txtBlocked' name='txtBlocked'>".$row['Blocked']."</td>";

								echo "<td id='txtAuthentication' name='txtAuthentication'>".$row['Authentication']."</td>";
								
								echo "<input name='txtEmail' id='txtEmail' type='hidden' value='".$row['Email']."'>";

								echo "<td><input name='btnUserSubmit' id='btnUserSubmit' type='submit' value='Sửa'></td>";

								echo "</form>";

								// Delete form
								echo "<form id='deleteUsr' action='' name='deleteUsr' method='POST'>";
								echo "<input type='hidden' name='emailToDelete' value='".$row['Email']."'>";
								echo "<td><input name='btnDeleteUsr' id='btnDeleteUsr' type='submit' value='Xóa' onclick='return confirm(\"Bạn có chắc chắn muốn xóa tài khoản này?\");'></td>";
								echo "</form>";

								echo "</tr>";
							}
						?>
					</table>

					<!-- Nút để mở modal -->
					<button class="btn btn-primary mt-4" onclick="showAddUserForm()"  style="margin-top: 15px;">Thêm tài khoản</button>

					<!-- row 2-->
					<div id="addUserForm" style="display: none;">
								<form name="signinform" class="clearfix" method="POST" action='admin-add-usr.php' onsubmit="return check_SigninAdmin()";>
									<button type="button" class="close-btn" onclick="closeAddUserForm()">&times;</button> <!-- "X" button -->
									<div class="billing-details-addusr">
										<div class="section-title">
											<h3 class="title">Tạo tài khoản </h4>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="wrongEmail" style="color:red; font-style:italic; display:none;" >*Nhập sai email*</p>
												<p id="nullEmail" style="color:red; font-style:italic; display:none;" >*Chưa nhập email*</p>
												<p id="existEmail" style="color:red; font-style:italic; display:none;" >*Email đã được đăng ký, đã có tài khoản, hãy đăng nhập*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='text' name='email' placeholder='Nhập Email' value='".$_POST['email']."'>";
												else
													echo "<input class='input' type='text' name='email' placeholder='Nhập Email'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="wrongPassword" style="color:red; font-style:italic; display:none;" >*Mật khẩu phải từ 8 ký tự trở lên*</p>
												<p id="nullPassword" style="color:red; font-style:italic; display:none;" >*Chưa nhập mật khẩu*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='password' name='pass' placeholder='Nhập Mật Khẩu' value='".$_POST['pass']."'>";
												else
													echo "<input class='input' type='password' name='pass' placeholder='Nhập Mật Khẩu'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="wrongRepassword" style="color:red; font-style:italic; display:none;" >*Nhập lại mật khẩu không khớp*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='password' name='repass' placeholder='Nhập Lại Mật Khẩu' value='".$_POST['repass']."'>";
												else
													echo "<input class='input' type='password' name='repass' placeholder='Nhập Lại Mật Khẩu'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="nullFullname" style="color:red; font-style:italic; display:none;" >*Chưa nhập họ và tên*</p>
												<p id="strangeFullname" style="color:red; font-style:italic; display:none;" >*Họ và tên không được có ký tự lạ*</p>
												<p id="numIDAdmin" style="color:red; font-style:italic; display:none;" >*Họ và tên không được có chữ số*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='text' name='fullname' placeholder='Nhập Họ Và Tên' value='".$_POST['fullname']."'>";
												else
													echo "<input class='input' type='text' name='fullname' placeholder='Nhập Họ Và Tên'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="wrongPhonenumber" style="color:red; font-style:italic; display:none;" >*Số điện thoại không phù hợp*</p>
												<p id="nullPhonenumber" style="color:red; font-style:italic; display:none;" >*Chưa nhập số điện thoại*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='text' name='phone' placeholder='Nhập Số Điện Thoại' value='".$_POST['phone']."'>";
												else
													echo "<input class='input' type='text' name='phone' placeholder='Nhập Số Điện Thoại'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="wrongAddress" style="color:red; font-style:italic; display:none;" >*Địa chỉ không phù hợp*</p>
												<p id="nullAddress" style="color:red; font-style:italic; display:none;" >*Chưa nhập địa chỉ*</p>
											</div>
											<?php
												if(isset($_POST['submitsignin']))
													echo "<input class='input' type='text' name='address' placeholder='Nhập Địa Chỉ' value='".$_POST['address']."'>";
												else
													echo "<input class='input' type='text' name='address' placeholder='Nhập Địa Chỉ'>";
											?>
										</div>
										<div class="form-group">
											<div class="error">
												<p id="nullAuth" style="color:red; font-style:italic; display:none;" >*Chưa chọn quyền*</p>
												<p>Quyền</p>
											</div>
											<?php
												require_once('../DataProvider.php');
												$Auth="";
												if(isset($_POST['submitsignin']))
													$Auth=$_POST['slcAuth'];
												$sql="SELECT * FROM AuthenticationUsr";
												$rs=DataProvider::executeQuery($sql);
												echo "<select name='slcAuth'>";
												if($Auth="")
													echo "<option value='' selected></option>";
												else
													echo "<option value=''></option>";
												while($row=mysqli_fetch_array($rs,MYSQLI_BOTH))
												{
													if($row['Authentication']==$Auth)
														echo "<option value='".$row['Authentication']."' selected>".$row['AuthenticationName']."</option>";
													else
														echo "<option value='".$row['Authentication']."' >".$row['AuthenticationName']."</option>";
												}
												echo "</select>";
											?>
										</div>

										<div align="center" class="form-group">
											<input class="primary-btn register" type="reset" name="resetsignin" value="làm mới">
											<input class="primary-btn register" type="submit" name="submitsignin" value="Thêm">
										</div>
									</div>
								</form>
					</div>
						<!-- /row 2-->
				</div>
				<!-- /MAIN -->

			</div>
			<!-- /row 1-->
			
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<?php
		require_once('../DataProvider.php');

		if(isset($_POST['submitsignin']))
		{
			$email=$_POST['email'];
			$passwd=$_POST['pass'];
			$passwd=sha1($passwd);
			$fullname=$_POST['fullname'];
			$phone=$_POST['phone'];
			$address=$_POST['address'];
			$auth=$_POST['slcAuth'];
			$sql="SELECT * FROM Usr WHERE Email='$email'";
			$rs=DataProvider::executeQuery($sql);
			if(mysqli_num_rows($rs)==1){
				// Hiển thị thông báo và form khi email đã tồn tại
				echo "<script> alert('Thêm thất bại: Email đã được đăng ký');</script>";
				echo "<script>
					document.getElementById('addUserForm').style.display='block';
				</script>";
			}
			else
			{
				$sql="INSERT INTO Usr (Email, Passwd, UsrName, PhoneNo, Address, Blocked, Authentication) VALUES ('$email', '$passwd', '$fullname', '$phone', '$address', '0', '$auth')";
				DataProvider::executeQuery($sql);
				header("Location: admin-add-usr.php");
			}

			
		}
	?>

<script>
    // Khi người dùng thay đổi bộ lọc
		function filterUsers(authentication) {
			var table = document.querySelector('table');
			var rows = table.getElementsByTagName('tr');

			// Lưu trạng thái bộ lọc vào localStorage
			localStorage.setItem('selectedAuth', authentication);

			for (var i = 1; i < rows.length; i++) {
				var cells = rows[i].getElementsByTagName('td');
				var auth = cells[5].innerText.trim(); // Giả sử cột quyền là cột thứ 6
				if (authentication === 'all' || auth === authentication) {
					rows[i].style.display = '';
				} else {
					rows[i].style.display = 'none';
				}
			}
		}
	

// mở form
	function showAddUserForm() {
        const form = document.getElementById('addUserForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
	function closeAddUserForm() {
        document.getElementById("addUserForm").style.display = "none";  // Hide the form
    }

	</script>


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
