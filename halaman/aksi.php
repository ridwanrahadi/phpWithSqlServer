<?php include "../controller/inc.connection.php";  ?>

<?php $SO = $_POST['idx'];
$mySql = "SELECT nm_cust,grandtotal,kd_user,keterangan,keterangan2 from salesorder
Where no_so='" . $_POST['idx'] . "'";
$myQry = sqlsrv_query($conn, $mySql) or die("Query  salah:" . sqlsrv_error());
$Data = sqlsrv_fetch_array($myQry);
?>
<h4>No Sales Order : <?php echo "$SO"; ?></h4>
<label>Nama Customer : <?php echo $Data['nm_cust']; ?></label><br>
<label>Total SO : <?php echo number_format($Data['grandtotal'],2); ?></label><br>
<label>Kode Sales : <?php echo $Data['kd_user']; ?></label>
<br>
<label>Keterangan : <?php echo $Data['keterangan']; ?></label>
<br>
<br>
<label>Note Akunting : <?php echo $Data['keterangan2']; ?></label>

<div class="table-responsive">


  <table class="table table-striped">
    <thead>
      <tr>
        <th>Kode Brg</th>
        <th>Nama Brg</th>
        <th>harga</th>
        <th>d1</th>
        <th>d2</th>
        <th>d3</th>
        <th>qty</th>
        <th>total</th>
      </tr>

    </thead>
    <tbody>
      <?php

      $mySql = "SELECT item_barang,tblIvMst.NmBrg,salesorder_item.harga,salesorder_item.disc,salesorder_item.disc2,salesorder_item.disc3,salesorder_item.jumlah,salesorder_item.subtotal FROM salesorder_item INNER JOIN tblIvMst ON salesorder_item.item_barang = tblIvMst.KdBrg
Where no_so='" . $_POST['idx'] . "'";
      $myQry = sqlsrv_query($conn, $mySql) or die("Query  salah:" . sqlsrv_error());
      while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {


      ?>

        <tr>
          <td><?php echo $kolomData['item_barang']; ?></td>
          <td><?php echo $kolomData['NmBrg']; ?></td>
          <td align="right"><?php echo number_format($kolomData['harga'],2); ?></td>
          <td><?php echo $kolomData['disc']; ?></td>
          <td><?php echo $kolomData['disc2']; ?></td>
          <td><?php echo $kolomData['disc3']; ?></td>
          <td><?php echo $kolomData['jumlah']; ?></td>
          <td align="right"><?php echo number_format($kolomData['subtotal'],2); ?></td>
        </tr>
      <?php } ?>
    </tbody>

  </table>
</div>