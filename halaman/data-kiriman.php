<?php include "../controller/inc.connection.php";  ?>

<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php
$mySql = "SELECT tblRekapKirimInvoices.NoFaktur, tblRekapKirim.NoBukti, tblRekapKirim.Tanggal, tblRekapKirim.Supir, tblRekapKirim.NoMobil, TblFak.NmCust,tblRekapKirimInvoices.Terkirim,tblRekapKirimInvoices.Jam_terkirim,tblRekapKirimInvoices.LPB,tblRekapKirimInvoices.Keterangan_LPB
            FROM tblRekapKirim INNER JOIN tblRekapKirimInvoices ON tblRekapKirim.NoBukti = tblRekapKirimInvoices.NoBukti INNER JOIN TblFak ON tblRekapKirimInvoices.NoFaktur = TblFak.NoBukti
            Where tblRekapKirimInvoices.NoFaktur='" . $_POST['idx'] . "'";
$params = array();
$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$myQry  = sqlsrv_query($conn, $mySql, $params, $options) or die(print_r(sqlsrv_errors(), true));
$cek = sqlsrv_num_rows($myQry);
$kolomData = sqlsrv_fetch_array($myQry);
if ($kolomData == 0) {
    # code...
    $status = "BELUM ADA DATA PENGIRIMAN";
} else {
    $status = "STATUS PENGIRIMAN :";
    if ($kolomData['Terkirim'] == 0 && $kolomData['LPB'] == 0) {
        $proseskirim = "DALAM PENGIRIMAN " . '<span class="glyphicon glyphicon-road" aria-hidden="true"></span>';
        $image_src = "asset/shiping.webp";
    } elseif ($kolomData['Terkirim'] == 1) {
        $image_src = "asset/deliver.webp";
        $proseskirim = "TERKIRIM " . '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' . " Jam : " . $kolomData['Jam_terkirim'];
    } elseif ($kolomData['LPB'] == 1) {
        $proseskirim = "Barang dikembalikan " . '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Keterangan : ' . $kolomData['Keterangan_LPB'] . "<br> Update time : " . $kolomData['Jam_terkirim'];
        $image_src = "uploads/" . $_POST['idx'] . ".jpg";
    }
}



?>

<h3><?php echo $status; ?></h3>
<div><?php echo $proseskirim;  ?></div><br>
<img src='<?php echo $image_src; ?>' align="centre" alt="Tidak ada foto" style="width:100%;">
<br></br>
<div class="form-group">
    <label>Nomor Expedisi :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NoBukti']; ?>" readonly="">
</div>
<div class="form-group">
    <label>Customer :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NmCust']; ?>" readonly="">
</div>
<div class="form-group">
    <label>Nama Supir :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['Supir']; ?>" readonly="">
</div>
<div class="form-group">
    <label>Tanggal SPK :</label>
    <input type="form-text" class="form-control" value="<?php $Date = $kolomData['Tanggal']->format('d/m/Y');

                                                        echo $Date; ?>" readonly="">
</div>
<div class="form-group">
    <label>No Mobil :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NoMobil']; ?>" readonly="">
</div>