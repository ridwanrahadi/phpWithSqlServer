<?php
include "inc.connection.php";
?>
 <?php


	  $typebarang = $_GET['typebarang'];

      $query = "select * from tblIvMst where Type='$typebarang'";
      $hasil = mssql_query($query);
      echo "<option>-- Pilih Barang --</option>";
      while ($r = mssql_fetch_array($hasil))
      {
        echo '<option value="'.$r['KdBrg'].'">'.$r['KdBrg'].' || '.$r['NmBrg'].'</option>';        
      }
      ?>