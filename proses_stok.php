<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
include "inc.connection.php";
?>
 <?php


	  $txtkodebrg = $_GET['txtkodebrg'];
      $query2  = "SELECT tblIvMst.KdBrg, tblIvMst.NmBrg, SUM(tblIvGstk.Qty) AS Qty, tblIvMst.Satuan
	  			  FROM tblIvGstk RIGHT OUTER JOIN
				  tblIvMst ON tblIvGstk.KdBrg = tblIvMst.KdBrg
	  				WHERE (tblIvGstk.KdGd IN ('A', 'SP'))
					  GROUP BY tblIvMst.KdBrg, tblIvMst.NmBrg, tblIvMst.Satuan
					  HAVING (tblIvMst.KdBrg = '$txtkodebrg')";
						$hasil2  = sqlsrv_query($conn,$query2) or die ("Query  salah:".sqlsrv_error());
						$databarang = sqlsrv_fetch_array($hasil2);
						
						echo number_format($databarang['Qty']); 
						echo " ";
						echo $databarang['Satuan'];

      ?>
      					