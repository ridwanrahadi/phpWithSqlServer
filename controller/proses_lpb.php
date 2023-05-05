<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include "inc.connection.php";  ?>


<?php
$mySql = "SELECT tblRekapKirimInvoices.NoFaktur, TblFak.NmCust, tblRekapKirimInvoices.Terkirim,tblRekapKirimInvoices.LPB,tblRekapKirimInvoices.Keterangan_LPB, tblRekapKirimInvoices.Jam_terkirim
            FROM   tblRekapKirimInvoices LEFT OUTER JOIN TblFak ON tblRekapKirimInvoices.NoFaktur = TblFak.NoBukti
      Where tblRekapKirimInvoices.NoFaktur='" . $_POST['idx'] . "'";
$myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
$cek = sqlsrv_num_rows($myQry);
$kolomData = sqlsrv_fetch_array($myQry);
?>
<label>Nomor JL :</label>
<input type="form-text" class="form-control" value="<?php echo $kolomData['NoFaktur']; ?>" readonly="">
<label>Nama Customer :</label>
<input type="form-text" class="form-control" value="<?php echo $kolomData['NmCust']; ?>" readonly="">
<label>Keterangan LPB :</label>
<input type="form-text" class="form-control" name="keterangan" placeholder="Keterangan">
<label>Bukti Foto :</label>
<input type="file" name="file_image" accept="image/*" capture="camera" />

<h2>
    <?php if ($kolomData['Terkirim'] == 1) {
    # code...
    echo "Sudah Terkirim <br>";
    if ($kolomData['Jam_terkirim'] == null) {
    } else {
      $jam = $kolomData['Jam_terkirim']->format('H:i:s');
      echo "Jam : " . $jam;
    }
  }
  if ($kolomData['LPB'] == 1) {
    echo "Pengembalian Barang : <br>";
    echo $kolomData['Keterangan_LPB'];
  } ?>
</h2>
<div class="modal-footer">
    <input type="hidden" name="id_nobukti" value="<?php echo $_POST['idx']; ?>">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-default btn-success" type="submit" name="lpb" value="Submit">Proses</button>

</div>