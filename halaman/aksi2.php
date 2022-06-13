<?php include "../controller/inc.connection.php";  ?>


 <div class="form-group">
    <?php 
        $mySql = "SELECT tblRekapKirimInvoices.NoFaktur, tblRekapKirim.NoBukti, tblRekapKirim.Tanggal, tblRekapKirim.Supir, tblRekapKirim.NoMobil, tblRekapKirim.Cetak, TblFak.NmCust
        FROM tblRekapKirim INNER JOIN tblRekapKirimInvoices ON tblRekapKirim.NoBukti = tblRekapKirimInvoices.NoBukti INNER JOIN TblFak ON tblRekapKirimInvoices.NoFaktur = TblFak.NoBukti
            Where tblRekapKirimInvoices.NoFaktur='".$_POST['idx']."'";
            $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
            $cek = sqlsrv_num_rows($myQry);
            $kolomData = sqlsrv_fetch_array($myQry);
    if ($cek == 0) {
    echo $cek;
    }
 ?>
    <h3 value="tes"></h3>
    <label>Nomor Expedisi :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NoBukti']; ?>" readonly="">
    <label>Customer :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NmCust']; ?>" readonly="">
    <label>Nama Supir :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['Supir']; ?>" readonly="">
    <label>Tanggal SPK :</label>
    <input type="form-text" class="form-control" value="<?php $Date = $kolomData['Tanggal']->format('d/m/Y');
     echo $Date; ?>" readonly="">
    <label>No Mobil :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NoMobil']; ?>" readonly="">
 </div>
