<?php 
$tglAwal  = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : date('m-d-Y');
$tglAkhir   = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : date('m-d-Y');
$kodebarang   = isset($_POST['txtcari1']) ? $_POST['txtcari1'] : '';
$NmSup   = isset($_POST['txtcari2']) ? $_POST['txtcari2'] : '';
$NoPO    = isset($_POST['txtcari3']) ? $_POST['txtcari3'] : '';
?>
<!DOCTYPE html>
<html>
<head>
 <!-- ... -->
 <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <script>
   $(document).ready(function(){
        $('#modal-rekap').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
             $.ajax({
                type : 'post',
                url : 'halaman/dateilbeli.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });

</script>
  

</head>
      <body>
         <h3 align="center">HISTORY PEMBELIAN</h3>
          <div class="container">
              <div class="jumbotron">
                  <form action="" method="POST" onSubmit="return validasi()">

    <div class="form-group">
      <label>Tanggal</label>
      <input type="form-text" class="datepicker" name="tanggal_awal" id="date" value="<?php echo $tglAwal; ?>" readonly="" >      
  <script>
    $('#date').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        todayHighlight: true,
        

    });
</script>
    </div>
    <div><label>To</label></div>
     <div class="form-group">
      <label>Tanggal</label>
      <input type="form-text" class="datepicker" name="tanggal_akhir" id="date2" value="<?php echo $tglAkhir; ?>" readonly="">      
  <script>
    $('#date2').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        todayHighlight: true,
        

    });
</script>
    </div>

  <div class="form-group">
    <label >Input :</label>
    <input type="form-text" class="form-control" name="txtcari1" id="txtcari1" value="<?php echo $kodebarang; ?>" placeholder="Kode Barang">
  </div>

  <div class="form-group">
    <label >Input :</label>
    <input type="form-text" class="form-control" name="txtcari2" id="txtcari2" value="<?php echo $NmSup; ?>" placeholder="Nama Supplier">
  </div>

  <div class="form-group">
    <label >Input :</label>
    <input type="form-text" class="form-control" name="txtcari3" id="txtcari3" value="<?php echo $NoPO; ?>" placeholder="No PO">
  </div>
  
  <button type="submit" name="cari" class="btn btn-primary">Submit</button>
   
</form>
              </div>
            
          </div>
          <div class="container">
          	<form action="" method="POST" onSubmit="return validasi()" >
          		<div class="form-group">
			    <label >Search BL :</label>
			    <input type="form-text" class="input" name="txtcariBL" id="txtcariBL" value="<?php echo $cariBL; ?>" placeholder="No Faktur">
			    <button type="submit" name="cariBL" class="btn btn-warning">Submit</button>
			 	 </div>
          	</form>
          </div>
   
                 <table class="table table-bordered table-striped table-hover">
  <thead>
  <tr>
    <th >NoFaktur</th>
    <th >TglFak</th>
    <th >Supplier</th>  
    <th >No PO</th>
    <th >Kode Brg</th>
    <th >Nama Barang</th>
    <th >Qty</th>
    <th >Sat</th>
    <th >Expired</th>
    <th >Harga</th>
    <th >Disc</th>
    <th >Harga Net</th>
    <th >Jumlah</th>

  </tr>
  </thead>
  <tbody>
  <?php
  # Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
 
  if (isset($_POST['cari'])) {
    $tglAwal = $_POST['tanggal_awal'];
    $tglAkhir = $_POST['tanggal_akhir'];
    $txtcari1 = $_POST['txtcari1'];
    $txtcari2 = $_POST['txtcari2'];
    $txtcari3 = $_POST['txtcari3'];
    if ($txtcari1 !='' AND $txtcari2 !='' AND $txtcari3) {
    $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."'  and TblBeliDtl.KdBrg like '%".$txtcari1."%' and TblSupplier.NmSup like '%".$txtcari2."%' and TblBeli.NoPO like '".$txtcari3."'
ORDER by TblBeli.Tgl ASC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
    }elseif($txtcari1 !='' AND $txtcari2 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' and TblBeliDtl.KdBrg like '%".$txtcari1."%' and TblSupplier.NmSup like '%".$txtcari2."%' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }elseif($txtcari1 !='' AND $txtcari3 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' and TblBeliDtl.KdBrg like '%".$txtcari1."%' and TblBeli.NoPO like '".$txtcari3."' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }elseif($txtcari2 !='' AND $txtcari3 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' and TblSupplier.NmSup like '%".$txtcari2."%' and TblBeli.NoPO like '".$txtcari3."' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }elseif($txtcari1 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' and TblBeliDtl.KdBrg like '%".$txtcari1."%' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }elseif($txtcari2 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' and TblSupplier.NmSup like '%".$txtcari2."%' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }elseif($txtcari3 !=''){
      $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' AND TblBeli.NoPO like '".$txtcari3."' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }else{
        $mySql = "SELECT TOP 1000 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.Tgl between '".$tglAwal."' AND '".$tglAkhir."' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
      }
	}else if (isset($_POST['cariBL'])) {
	 $cariBL = $_POST['txtcariBL'];
	$mySql = "SELECT TOP 100 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.NoBukti = '".$cariBL."'";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
}else{
  $mySql = "SELECT TOP 10 TblBeli.NoBukti, TblBeli.Tgl, TblBeli.KdSup, TblSupplier.NmSup, TblBeli.NoPO, TblBeliDtl.KdBrg,TblBeliDtl.NmBrg, TblBeliDtl.Qty, TblBeliDtl.Satuan,TblBeliDtl.Tglexpired, TblBeliDtl.Hrg, TblBeliDtl.PrsDisc,TblBeliDtl.HrgNet, TblBeliDtl.Jumlah, TblBeli.NonStock
FROM TblBeli INNER JOIN TblBeliDtl ON TblBeli.NoBukti = TblBeliDtl.NoBukti INNER JOIN tblSupplier ON tblBeli.KdSup = tblSupplier.KdSup
Where TblBeli.NonStock='0' 
ORDER by TblBeli.Tgl DESC ";
$myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  }
  while ($kolomData = mssql_fetch_array($myQry)) {
    
    # Membaca Kode Penjualan/ Nomor transaksi
 
?>

  <tr>
    <td style="font-size: 11px"><?php echo $kolomData['NoBukti']; ?></td>
    <td style="font-size: 11px"><?php echo date_format (new DateTime($kolomData['Tgl']), 'd-m-Y');?></td>
    <td style="font-size: 11px"><?php echo $kolomData['NmSup']; ?></td>
    <td style="font-size: 11px"><?php echo $kolomData['NoPO']; ?></td>
    <td style="font-size: 11px"><?php echo $kolomData['KdBrg']; ?></td>
    <td style="font-size: 11px"><?php echo $kolomData['NmBrg']; ?></td>
    <td style="font-size: 11px"><?php echo number_format($kolomData['Qty']); ?></td>
    <td style="font-size: 11px"><?php echo $kolomData['Satuan']; ?></td>
    <td style="font-size: 11px"><?php echo date_format (new DateTime($kolomData['Tglexpired']), 'd-m-Y');?></td>
    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['Hrg']); ?></td>
    <td style="font-size: 11px"> <?php echo $kolomData['PrsDisc']; ?></td> 
    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['HrgNet']); ?></td>
    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['Jumlah']); ?></td>
   
</tr>
  <?php } ?>
  </tbody>
</table>
 <div id="modal-rekap" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Pengiriman</h4>
      </div>
      <div class="modal-body">
                <div class="hasil-data"></div>

        </div>
     </div>

  </div>
</div>

      </body>
</html>

