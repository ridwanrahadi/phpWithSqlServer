<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include "../controller/inc.connection.php";  ?>


<div class="form-group">
    <?php

  $image_src = "image/katalog/" . $_POST['idx'] . ".jpg";
  ?>
    <div class="form-group">
        <img src='<?php echo $image_src; ?>' align="centre" alt="Pic not found" style="width:100%;">
    </div>
    <br>
    <?php
  $mySql = "SELECT  TblIvType.NmType, tblIvMst.KdBrg,tblivmst.Jenis, tblIvMst.NmBrg, tblIvGstk.Qty, tblIvMst.HrgJual, tblIvGstk.KdGd,tblIvMst.Satuan,tblIvMst.Packing3
              FROM tblIvMst INNER JOIN
              TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
              tblIvGstk ON tblIvMst.KdBrg = tblIvGstk.KdBrg 
      Where tblIvMst.KdBrg='" . $_POST['idx'] . "' and tblIvGstk.KdGd='CB'";
  $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
  $kolomData = sqlsrv_fetch_array($myQry);
  $mySql2 = "SELECT  TblIvType.NmType, tblIvMst.KdBrg,tblivmst.Jenis, tblIvMst.NmBrg, tblIvGstk.Qty, tblIvMst.HrgJual, tblIvGstk.KdGd,tblIvMst.Satuan,tblIvMst.Packing3
              FROM tblIvMst INNER JOIN
              TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
              tblIvGstk ON tblIvMst.KdBrg = tblIvGstk.KdBrg 
      Where tblIvMst.KdBrg='" . $_POST['idx'] . "' and tblIvGstk.KdGd='SP'";
  $myQry2 = sqlsrv_query($conn, $mySql2) or die(print_r(sqlsrv_errors(), true));
  $kolomData2 = sqlsrv_fetch_array($myQry2);
  ?>



    <h1><?php echo $kolomData['KdBrg']; ?></h1>

    <p><?php echo $kolomData['NmBrg']; ?></p>

    <ul>
        <li>Stock Gudang Cirebon : <?php echo number_format($kolomData['Qty']); ?> - <?php echo $kolomData['Satuan']; ?>
        </li>
        <li>Stock Gudang Sapan : <?php echo number_format($kolomData2['Qty']); ?> - <?php echo $kolomData2['Satuan']; ?>
        </li>
        <li>Jenis Barang : <?php echo $kolomData['Jenis']; ?> </li>
        <li>Type Barang : <?php echo $kolomData['NmType']; ?> </li>
        <li>Packaging : <?php echo $kolomData['Packing3']; ?></li>
    </ul>
</div>