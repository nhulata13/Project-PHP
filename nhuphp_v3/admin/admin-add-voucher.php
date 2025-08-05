<?php
require_once('../DataProvider.php');

// Xử lý yêu cầu thêm/sửa/xóa nếu có
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $voucherID = $_POST['VoucherID'];
            $startDate = $_POST['StartDate'];
            $endDate = $_POST['EndDate'];
            $discountPercent = $_POST['DiscountPercent'];
            // Kiểm tra VoucherID đã tồn tại chưa
            $sql_check = "SELECT COUNT(*) AS count FROM voucher WHERE VoucherID = '$voucherID'";
            $result = DataProvider::executeQuery($sql_check);
            $row = mysqli_fetch_assoc($result);

            if ($row['count'] > 0) {
                // VoucherID đã tồn tại
                echo "<script>alert('VoucherID đã tồn tại. Vui lòng thêm ID khác.');</script>";
            } else {
                $sql_add = "INSERT INTO voucher (VoucherID, StartDate, EndDate, DiscountPercent) VALUES ('$voucherID', '$startDate', '$endDate', $discountPercent)";
                DataProvider::executeQuery($sql_add);
            }
        } elseif ($action === 'edit') {
            $voucherID = $_POST['VoucherID'];
            $startDate = $_POST['StartDate'];
            $endDate = $_POST['EndDate'];
            $discountPercent = $_POST['DiscountPercent'];

            $sql_edit = "UPDATE voucher SET StartDate = '$startDate', EndDate = '$endDate', DiscountPercent = $discountPercent WHERE VoucherID = '$voucherID'";
            DataProvider::executeQuery($sql_edit);
        } elseif ($action === 'delete') {
            $voucherID = $_POST['VoucherID'];
            $sql_delete = "DELETE FROM voucher WHERE VoucherID = '$voucherID'";
            DataProvider::executeQuery($sql_delete);
        }
    }
}

// Lấy danh sách voucher
$sql_vouchers = "SELECT * FROM voucher";
$result_vouchers = DataProvider::executeQuery($sql_vouchers);
$vouchers = [];
while ($row = mysqli_fetch_assoc($result_vouchers)) {
    $vouchers[] = $row;
}
?>

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

    <div class="section">
		<!-- container -->
		<div class="container container-admin">
		    <?php include('php/navigationUsr.php') ?>
            <div class="row row-admin" style="padding: 15px;">
                <h3 class="mt-4" style="padding: 15px;">Quản Lý Voucher</h3>

                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>ID Voucher</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Ngày Kết Thúc</th>
                        <th>Phần Trăm Giảm Giá</th>
                        <th>Hành Động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($vouchers as $voucher): ?>
                        <tr>
                            <td><?= $voucher['VoucherID'] ?></td>
                            <td><?= $voucher['StartDate'] ?></td>
                            <td><?= $voucher['EndDate'] ?></td>
                            <td><?= $voucher['DiscountPercent'] ?>%</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editVoucher('<?= $voucher['VoucherID'] ?>', '<?= $voucher['StartDate'] ?>', '<?= $voucher['EndDate'] ?>', <?= $voucher['DiscountPercent'] ?>)">Sửa</button>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa voucher này?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="VoucherID" value="<?= $voucher['VoucherID'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <button class="btn btn-primary mt-4" onclick="showAddVoucherModal()">Thêm Voucher Mới</button>

                <!-- Modal Thêm/Sửa Voucher -->
                <div id="voucherModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Thêm Voucher</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="action" id="modalAction" value="add">
                                    <div class="form-group">
                                        <label for="VoucherID">ID Voucher</label>
                                        <input type="text" class="form-control" name="VoucherID" id="VoucherID" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="StartDate">Ngày Bắt Đầu</label>
                                        <input type="date" class="form-control" name="StartDate" id="StartDate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="EndDate">Ngày Kết Thúc</label>
                                        <input type="date" class="form-control" name="EndDate" id="EndDate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="DiscountPercent">Phần Trăm Giảm Giá</label>
                                        <input type="number" class="form-control" name="DiscountPercent" id="DiscountPercent" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
    <script>
        function showAddVoucherModal() {
            document.getElementById('modalTitle').innerText = 'Thêm Voucher';
            document.getElementById('modalAction').value = 'add';
            document.getElementById('VoucherID').value = '';
            document.getElementById('StartDate').value = '';
            document.getElementById('EndDate').value = '';
            document.getElementById('DiscountPercent').value = '';
            $('#voucherModal').modal('show');
        }

        function editVoucher(id, startDate, endDate, discount) {
            document.getElementById('modalTitle').innerText = 'Sửa Voucher';
            document.getElementById('modalAction').value = 'edit';
            document.getElementById('VoucherID').value = id;
            document.getElementById('VoucherID').readOnly = true; // Không cho chỉnh sửa

            document.getElementById('StartDate').value = startDate;
            document.getElementById('EndDate').value = endDate;
            document.getElementById('DiscountPercent').value = discount;
            $('#voucherModal').modal('show');
        }
    </script>
    </body>
    </html>
    