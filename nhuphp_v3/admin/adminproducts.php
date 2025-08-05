<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
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
				<div id="main" class="col-md-9">
					
					<!-- store top filter -->
					<div class="store-filter clearfix">
						<div class="pull-right">
						<button id="filterToggleBtn" class="btn btn-primary">
							<i class="fa fa-filter"></i>
						</button>
						<a href="adminproducts.php" class="btn btn-primary"><i class="fa fa-refresh"></i></a>				
						<a href="admin-add-product.php" class="btn btn-primary"> THÊM SẢN PHẨM</a>

						<!-- ASIDE -->
				<div id="filterForm" class="col-md-3" style="display: none;">
					<!-- aside widget -->
					<form action="adminproducts.php" method="GET" id="formAdvanceSearch" name="formAdvanceSearch" onsubmit="return checkAdvancedSearch()">
						<div class="aside">
							<h3 class="aside-title">Tìm kiếm nâng cao:</h3>
							<?php
								if (isset($_GET['txtSearch']))
								echo "<input type=\"hidden\" name=\"txtSearch\" value=\"".$_GET['txtSearch']."\">";
							?>

							

							<ul class="filter-list">
								<span class="text-uppercase">Loại:</span>
								<select class="input aside-type-input" name="slcType">
									<?php
										require_once("../DataProvider.php");
										$sql = "SELECT DISTINCT ProductTypeName FROM ProductType";
										$Type = DataProvider::executeQuery($sql);
										$type = "";
										if(isset($_GET['slcType']))
											$type = $_GET['slcType'];
										if($type == "") echo "<option value='' selected></option>";
										else echo "<option value=''></option>";
										while($row = mysqli_fetch_array($Type,MYSQLI_BOTH))
										{
											echo "<option value='".$row['ProductTypeName']."'";
											if($type == $row['ProductTypeName']) echo "selected";
											echo ">".$row['ProductTypeName']."</option>";
										}
									?>
								</select>
							</ul>

							<ul class="filter-list">
								<li><span class="text-uppercase">Giá:</span></li>
								<input type="text" placeholder="Từ" class="input aside-input" id="txtFrom" name="txtFrom" onkeypress="return Keypress(event);" onkeyup="addDot(this);"
									<?php
										if(isset($_GET['txtFrom']))
										echo "value=\"".$_GET['txtFrom']."\""
									?>
								>
								<input type="text" placeholder="Đến" class="input aside-input" id="txtTo" name="txtTo" onkeypress="return Keypress(event);" onkeyup="addDot(this);"
									<?php
										if(isset($_GET['txtTo']))
										echo "value=\"".$_GET['txtTo']."\""
									?>
								>
								<p id="priceError" align="center" style="color:red;"></p>
							</ul>

							<!--  -->
							<ul class="filter-list">
								<span class="text-uppercase">Sắp xếp:</span>
								<select class="input aside-sort-by" name="slcSortBy">
									<?php
										$valueSortBy = array("","ProductName","UnitPrice","Date");
										$SortBy = array("","Tên","Giá","Ngày");
										$sortBy = "";
										if(isset($_GET['slcSortBy']))
											$sortBy = $_GET['slcSortBy'];
										for($i=0;$i<count($valueSortBy);$i++)
										{
											echo "<option value='$valueSortBy[$i]'";
											if($sortBy==$valueSortBy[$i]) echo "selected";
											echo ">$SortBy[$i]</option>";
										}
									?>
								</select>

								<select class="input aside-sort" name="slcSort">
									<?php
										$valueSort = array("ASC","DESC");
										$Sort = array("Tăng dần","Giảm dần");
										$sort = "";
										if(isset($_GET['slcSort']))
											$sort = $_GET['slcSort'];
										for($i=0;$i<count($valueSort);$i++)
										{
											echo "<option value='$valueSort[$i]'";
											if($sort==$valueSort[$i]) echo "selected";
											echo ">$Sort[$i]</option>";
										}
									?>
								</select>
							</ul>

							<button class="primary-btn aside-button" type="reset">Làm mới</button>
							<button class="primary-btn aside-button" type="submit">Tìm kiếm</button>
						</div>
					</form>
					<!-- /aside widget -->
				</div>
				<!-- /ASIDE -->
							<ul class="store-pages">
								<?php
									//Initiation
									$sql = "SELECT * FROM Product INNER JOIN ProductType WHERE Product.ProductTypeID = ProductType.ProductTypeID AND block = 0";
									$sql_where = "";
									$rowsPerPage = 9;
									//Initiation

									if(isset($_POST['btnEditDel']))
									{
										$editDel = $_POST['btnEditDel'];
										$ProductID = $_POST['txtID'];
										$sql="SELECT * FROM Product WHERE ProductID=$ProductID";
										$rs=DataProvider::executeQuery($sql);
										$rowProduct=mysqli_fetch_array($rs,MYSQLI_BOTH);
										if($editDel=="Sửa")
										{
											$sql_type = "SELECT ProductTypeID FROM ProductType WHERE ProductTypeName ='".$_POST['qslcProductType']."'";
											$rs_type = DataProvider::executeQuery($sql_type);
											$TypeID = "";
											while ($row=mysqli_fetch_array($rs_type,MYSQLI_BOTH))
												$TypeID = $row['ProductTypeID'];
											$rawPrice = str_replace('.', '', $_POST['qtxtPrice']);
											$sql_update = "UPDATE Product SET 
																				ProductName = '".$_POST['qtxtProductName']."',
																				ProductTypeID = '$TypeID',
																				UnitPrice = '".$rawPrice."',
																				Quantity = '".$_POST['qtxtQuantity']."',
																				Description = '".$_POST['qtxtDescription']."'
											WHERE ProductID = '".$ProductID."'";
											DataProvider::executeQuery($sql_update);
											echo "<script>alert('Đã sửa thành công')</script>";
											$sql_where = " AND ProductID =".$ProductID;
										}
										else if($editDel=="Xóa")
										{
											$sqlDelete="UPDATE Product SET block = 1 WHERE ProductID = '$ProductID'";
											echo "<script>alert('Đã xóa thành công')</script>";
											DataProvider::executeQuery($sqlDelete);
										}
									}
									else
									{
										//add $sql for ProductName
										if(isset($_GET['txtSearch'])&&isset($_GET['txtSearch'])!="")
											$sql_where = "AND ProductName LIKE '%".$_GET['txtSearch']."%'";
										//add $sql for ProductName

										//add $sql for Price
										if(isset($_GET['txtFrom'])&&isset($_GET['txtFrom'])!="")
										{
											$txtFrom = $_GET['txtFrom'];
											// $txtFrom = preg_replace("/[^0-9]/",'',$txtFrom) * 1;			
											$txtFrom = preg_replace("/[^0-9]/",'',$txtFrom);
$txtFrom = intval($txtFrom); // Chuyển đổi chuỗi thành số nguyên
							
										}
										if(isset($_GET['txtTo'])&&isset($_GET['txtTo'])!="")
										{
											$txtTo = $_GET['txtTo'];
											// $txtTo = preg_replace("/[^0-9]/",'',$txtTo) * 1;							
											$txtTo = preg_replace("/[^0-9]/",'',$txtTo);
$txtTo = intval($txtTo); // Chuyển đổi chuỗi thành số nguyên
			
										}

										if(isset($txtFrom)&&$txtFrom != 0)
										{
											$sql_where .= " AND UnitPrice >= $txtFrom";
											if(isset($txtFrom)&&$txtTo != 0)
												$sql_where .= " AND UnitPrice <= $txtTo";
										}
										else
										{
											if(isset($txtFrom)&&$txtTo != 0)
												$sql_where .= " AND UnitPrice <= $txtTo";
										}
										//add $sql for Price

										//add $sql for Size
									
										//add $sql for Size

										//add $sql for Type
										if(isset($_GET['slcType']))
										{
											$Type = $_GET['slcType'];
											if($Type != "")
											$sql_where .= " AND ProductTypeName ='$Type'";
										}
										//add $sql for Type

										//add $sql for Gender
										if(isset($_GET['slcGender']))
										{
											$Gender = $_GET['slcGender'];
											if ($Gender != "")
											$sql_where .= " AND Gender ='$Gender'";
										}
										//add $sql for Gender
									}
									//Merge $sql
									if($sql_where != "")
									$sql .= $sql_where;

									//add ORDER BY
									if(isset($_GET['slcSortBy'])&&isset($_GET['slcSort']))
									{
										$slcSortBy = $_GET['slcSortBy'];
										if($slcSortBy!="")
										{
											$slcSort = $_GET['slcSort'];
											$sql .= " ORDER BY $slcSortBy $slcSort";
										}
									}
									//add ORDER BY

									//Paging
									$page=1;
									if(isset($_GET['page']))
										$page = $_GET['page'];
									$offset = ($page - 1) * $rowsPerPage;
									$result_numrows = DataProvider::executeQuery($sql);
									$numrows = mysqli_num_rows($result_numrows);
									//Paging

									//Page navigation
									$maxPage = ceil($numrows/$rowsPerPage);
									$thisLocation = preg_replace("/&page=(\d*)/","",$_SERVER['REQUEST_URI']);
									$nav = "";
									for($i = 1; $i <= $maxPage; $i++)
									{
										if($i == $page)
											$nav .= "<li class=\"active\">$i</li>";
										else
										{
											if (!preg_match("/(.*)[?]/",$thisLocation)) 
												$thisLocation .= "?";
											$nav .= "<li><a href=\"$thisLocation&page=$i\">$i</a></li>";
										}
									}

									$thisLocation = preg_replace("/&page=(\d*)/","",$_SERVER['REQUEST_URI']);
									if (!preg_match("/(.*)[?]/",$thisLocation)) 
												$thisLocation .= "?";
									if ($page > 1)
									{
										$pagePrev = $page - 1;
										$prev  = " <a href=\"$thisLocation&page=$pagePrev\"><i class=\"fa fa-backward\"></i></a> ";

										$first = " <a href=\"$thisLocation&page=1\"><i class=\"fa fa-fast-backward\"></i></a> ";
									}
									else
									{
										$prev  = '&nbsp;'; // dang o trang 1, khong can in lien ket trang truoc
										$first = '&nbsp;'; // va lien ket trang dau
									}

									if ($page < $maxPage)
									{
										$pageNext = $page + 1;
										$next = " <a href=\"$thisLocation&page=$pageNext\"><i class=\"fa fa-forward\"></i></a> ";

										$last = " <a href=\"$thisLocation&page=$maxPage\"><i class=\"fa fa-fast-forward\"></i></a> ";
									}
									else
									{
										$next = '&nbsp;'; // dang o trang cuoi, khong can in lien ket trang ke
										$last = '&nbsp;'; // va lien ket trang cuoi
									}

									echo "$first $prev $nav $next $last";
									//Page navigation

									//Execute $sql with LIMIT to paging
									$sql .= " LIMIT $offset, $rowsPerPage";
									$result = DataProvider::executeQuery($sql);
									//Execute $sql
								?>
							</ul>
						</div>
					</div>
					<!-- /store top filter -->

					<!-- STORE -->
					<div id="store">
							<?php
								//Show Products
								$i=0; $Count=0;
								while($row=mysqli_fetch_array($result,MYSQLI_BOTH))
								{
									if($i==0)
									{
										echo "<!-- row -->";
										echo "<div class='row'>";
									}
									echo "<!-- Product Single -->";
									echo "<form name='formAdmin' method='POST' action='admin-edit-del.php'>";
									echo "<input type='hidden' name='txtID' value='".$row['ProductID']."'/>";
									echo "<div class='col-md-4 col-sm-6 col-xs-6'>";
									echo "<div class='product product-single'>";
									echo "<img src='../img/".$row["imgsrc"]."' width='258px' height='344px' alt='".$row["ProductName"]."'>";
									echo "<div class='product-body'>";
									echo "<h5 class='product-price'><script>document.write(PriceDot(".$row["UnitPrice"]."))</script> - SL: ".$row['Quantity']." </h5>";
									echo "<h2 class='product-name'><p>" .$row["ProductName"]. "</p></h2>";
									echo "<div class='product-btns'>";
									echo "<input type='submit' class='primary-btn add-to-cart' value='Sửa / Xóa'>";
									echo "</div>";
									echo "</div>";
									echo "</div>";
									echo "</div>";
									echo "</form>";
									echo "<!-- /Product Single -->";
									if($i==2)
									{
										echo "</div>";
										echo "<!-- row -->";
										$i=0;
									}
									else
										$i++;
									$Count++;
								}
								if($Count==0)
									echo "<h2>Không có sản phẩm nào hết nha bé yêu <i class=\"fa fa-heart\"></i></h2>";							
								//Show Products
							?>
						</div>
						<!-- /row -->

						
					</div>
					<!-- /STORE -->
					 
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
	<script>
    document.getElementById("filterToggleBtn").addEventListener("click", function () {
        const filterForm = document.getElementById("filterForm");
        // Toggle hiển thị form
        if (filterForm.style.display === "none") {
            filterForm.style.display = "block";
        } else {
            filterForm.style.display = "none";
        }
    });
</script>
</body>

</html>
