<?php
include "inc.connection.php";
?>
 <?php


	  $txtkodebrg = $_GET['txtkodebrg'];
      $query2  = "SELECT tblIvMst.KdBrg, tblIvMst.NmBrg,tblIvMst.Satuan
	  			  FROM tblIvMst WHERE KdBrg = '$txtkodebrg'";
						$hasil2  = sqlsrv_query($conn,$query2) or die ("Query  salah:".sqlsrv_error());
						$databarang = sqlsrv_fetch_array($hasil2);
						echo '<option value="'.$databarang['Satuan'].'">'.$databarang['Satuan'].'</option>';

      ?>
      			