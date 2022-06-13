<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
$user=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>

  <!-- ... -->
 
  <script>
   $(document).ready(function(){
        $('#modal-open').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
             $.ajax({
                type : 'post',
                url : 'halaman/expired.php',
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
<h3 align="center">INVENTORI</h3>
<div class="container">
<div class="jumbotron">
  
  <form action="" method="POST">
   
  <div class="form-group">

    <label>Cari Data</label>
    <input type="form-text" name="txtcari" class="form-control" id="search" placeholder="kode / nama Barang" required="">
    <small class="form-text text-muted">Input data dengan benar.</small>
  </div>
  <button type="submit" name="cari" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
        <div class="container">
          <table id="example" class="display nowrap" style="width:100%">
  <thead>
    <tr>
    <th >No</th>
    <th >Type Produk</th>
    <th >Kode Barang</th>
    <th >Nama Barang</th>
    <th >Qty</th>
    <th >Harga exc ppn</th>
    <th >Harga minimum</th>
    <th >Kd Gudang</th>
    <th >Satuan</th>
    <th >Packing</th>
    </tr>
  </thead>
  <tbody>
   <?php

  $nomor = 1;
  $txtcari = $_POST['txtcari'];
  if ($txtcari !='') {
  $mySql  = "SELECT  TblIvType.NmType, tblIvMst.KdBrg, tblIvMst.NmBrg, tblIvGstk.Qty, tblIvMst.HrgJual, tblIvMst.HrgJualMin, tblIvGstk.KdGd,tblIvMst.Satuan,tblIvMst.Packing3
FROM tblIvMst INNER JOIN
TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
tblIvGstk ON tblIvMst.KdBrg = tblIvGstk.KdBrg 
Where tblIvGstk.KdGd IN ('sp','cb') and tblIvMst.KdBrg Like '%".$txtcari."%' OR TblIvmst.Nmbrg Like '%".$txtcari."%' And tblIvGstk.KdGd IN ('sp','cb')";
  $myQry  = sqlsrv_query($conn, $mySql) or die("Query  salah:" . sqlsrv_error());
  }else{
  $mySql  = "SELECT TOP 100 TblIvType.NmType, tblIvMst.KdBrg, tblIvMst.NmBrg, tblIvGstk.Qty,tblIvMst.HrgJual, tblIvMst.HrgJualMin, tblIvGstk.KdGd,tblIvMst.Satuan,tblIvMst.Packing3
FROM tblIvMst INNER JOIN
TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
tblIvGstk ON tblIvMst.KdBrg = tblIvGstk.KdBrg 
where tblIvGstk.Qty > 0 order by tblIvGstk.Qty DESC" ;
  $myQry  = sqlsrv_query($conn, $mySql) or die("Query  salah:" . sqlsrv_error());
  }
  while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
  ?>
   
  <tr>
    <td><?php echo $nomor++; ?></td>
    <td><?php echo $kolomData['NmType']; ?> </td>
    <td><a href="#modal-open" data-id='<?php echo $kolomData['KdBrg']; ?>' data-toggle='modal'><?php echo $kolomData['KdBrg']; ?> </td>
    <td><?php echo $kolomData ['NmBrg']; ?> </td>
    <td><?php echo number_format($kolomData['Qty']);?></td>
    <td><?php echo number_format($kolomData['HrgJual']);?></td>
    <td><?php if ($LevelLogin == "admin") {
      echo number_format($kolomData['HrgJualMin']);}else{
        echo 0;
      }?></td>
    <td align="center"><?php echo $kolomData ['KdGd']; ?> </td>
    <td class="angkaL"><?php echo $kolomData['Satuan']; ?> </td>
    <td class="angkaL"><?php echo $kolomData['Packing3']; ?> </td>
    
  </tr>
  <?php } ?>
  </tbody>
 
</table>
</div>
<div id="modal-open" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Item detail</h4>
      </div>
      <div class="modal-body">
                <div class="hasil-data"></div>

        </div>
     </div>

  </div>
</div>
</body>
</html>

            
       
         
                

