<?php
class DataProvider
{
	public static function executeQuery($sql)
	{
		require ('connectiondata.inc');
		//include_once('error.inc');
		// 1. Tao ket noi CSDL
		if (!($connection = mysqli_connect($hostName,$username,$password,$databaseName)))
			die ("couldn't connect to localhost");
		
		// 2. Thuc thi cau truy van
		mysqli_set_charset($connection, "utf8");
		$result = mysqli_query($connection, $sql);
			//showError();
		
		// 3. Dong ket noi CSDL
		mysqli_close($connection);
		
		return $result;
	}
}
?>
