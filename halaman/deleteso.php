<?php
if ($_GET) {
	# HAPUS Sales Order
	if (isset($_GET['Act'])) {
		if (trim($_GET['Act']) == "DeleteSo") {

			$msSql = "select * from salesorder where no_so='" . $_GET['id'] . "' and proses='1'";
			$params = array();
			$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
			$myQry = sqlsrv_query($conn, $msSql, $params, $options) or die("Query  salah:" . sqlsrv_error());
			$rows = sqlsrv_num_rows($myQry);

			if ($rows > 0) {
				echo "<meta http-equiv='refresh' content='0; url=?page=Data_SalesOrder'>";
				echo "<script>alert(' Sales Order No = " . $_GET['id'] . " sudah di proses');</script>";
			} else {
				# Hapus jika belum di proses
				$msSql = "DELETE FROM salesorder WHERE no_so='" . $_GET['id'] . "'";
				sqlsrv_query($conn, $msSql) or die("Query  salah:" . sqlsrv_error());
				$msSql = "DELETE FROM salesorder_item WHERE no_so='" . $_GET['id'] . "'";
				sqlsrv_query($conn, $msSql) or die("Query  salah:" . sqlsrv_error());
				echo "<meta http-equiv='refresh' content='0; url=?page=Data_SalesOrder'>";
				echo "<script>alert('Delete berhasil!');</script>";
			}
		}
	}
}