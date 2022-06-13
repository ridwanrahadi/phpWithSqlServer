<?php
include "inc.connection.php";
?>
 <?php


	  $txtkodebrg = $_GET['txtkodebrg'];
      $query2  = "SELECT tblIvMst.KdBrg, tblIvMst.JnsPPN
	  			  FROM tblIvMst WHERE KdBrg = '$txtkodebrg'";
						$hasil2  = sqlsrv_query($conn,$query2) or die ("Query  salah:".sqlsrv_error());
						$databarang = sqlsrv_fetch_array($hasil2);
						if ($databarang['JnsPPN'] == '01') {
							$status = "PPN";
							# code...
						}elseif ($databarang['JnsPPN'] == '02') {
							# code...
							$status = "NBKP";
						}elseif ($databarang['JnsPPN'] == '03') {
							# code...
							$status = "PBBS";
						}
						
						echo '<option value="'.$status.'">'.$status.'</option>';


      ?>
      			