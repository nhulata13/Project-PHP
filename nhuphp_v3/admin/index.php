<!DOCTYPE html>
<?php
	include('php/sessionAdmin.php');
	switch($_SESSION['Authentication'])
	{
		case "Admin":
			header('Location: Dashboard.php');
			break;
		case "Store":
			header('Location: adminproducts.php');
			break;
		case "Invoice":
			header('Location: admin-invoice.php');
			break;
	}
?>