<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
include "inc.connection.php";
?>
 <?php


	  $txtkodebrg = $_GET['txtkodebrg'];
      $query2  = "SELECT tblIvMst.KdBrg, tblIvMst.HrgJual
	  			  FROM tblIvMst WHERE KdBrg = '$txtkodebrg'";
						$hasil2  = sqlsrv_query($conn,$query2) or die ("Query  salah:".sqlsrv_error());
						$databarang = sqlsrv_fetch_array($hasil2);
						echo number_format($databarang['HrgJual']);


      ?>
      			