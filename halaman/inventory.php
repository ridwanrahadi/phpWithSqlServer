<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
$user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<head>

    <!-- ... -->

    <script>
    $(document).ready(function() {
        $('#modal-open').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'halaman/detail-item.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.hasil-data').html(data); //menampilkan data ke dalam modal
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
                    <input type="form-text" name="txtcari" class="form-control" id="search"
                        placeholder="kode / nama Barang" required="">
                    <small class="form-text text-muted">Input data dengan benar.</small>
                </div>
                <button type="submit" name="cari" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="container">
        <table id="tabelinventory" class="stripe" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Type Produk</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty-SP</th>
                    <th>Qty-CB</th>
                    <th>Qty-SPX</th>
                    <th>Qty-CBX</th>
                    <th>Qty-SS</th>
                    <th>Satuan</th>
                    <th>Harga exc ppn</th>
                    <th>Harga minimum</th>
                    <th>Packing</th>
                </tr>
            </thead>
            <tbody>
                <?php

        $nomor = 1;
        $txtcari = $_POST['txtcari'];
        if ($txtcari != '') {
          $mySql  = "SELECT  TblIvType.NmType, tblIvMst.KdBrg, tblIvMst.NmBrg,SP.Qty as QtySP,CB.Qty as QtyCB,X.Qty as QtyX,CBX.Qty as QtyCBX,SS.Qty as QtySS, tblIvMst.HrgJual, tblIvMst.HrgJualMin,tblIvMst.Satuan,tblIvMst.Packing3
                    FROM tblIvMst INNER JOIN
                    TblIvType ON tblIvMst.Type = TblIvType.KdType Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SP') AS SP ON SP.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='CB') AS CB ON CB.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SPX') AS X ON X.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='CBX') AS CBX ON CBX.KdBrg = tblIvMst.KdBrg
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SS') AS SS ON SS.KdBrg = tblIvMst.KdBrg 
Where (tblIvMst.KdBrg Like '%" . $txtcari . "%') OR (TblIvmst.Nmbrg Like '%" . $txtcari . "%')";
          $myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        } else {
          $mySql  = "SELECT TOP 20  TblIvType.NmType, tblIvMst.KdBrg, tblIvMst.NmBrg,SP.Qty as QtySP,CB.Qty as QtyCB,X.Qty as QtyX,CBX.Qty as QtyCBX,SS.Qty as QtySS, tblIvMst.HrgJual, tblIvMst.HrgJualMin,tblIvMst.Satuan,tblIvMst.Packing3
                    FROM tblIvMst INNER JOIN
                    TblIvType ON tblIvMst.Type = TblIvType.KdType Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SP') AS SP ON SP.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='CB') AS CB ON CB.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SPX') AS X ON X.KdBrg = tblIvMst.KdBrg 
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='CBX') AS CBX ON CBX.KdBrg = tblIvMst.KdBrg
                    Left outer JOIN
                    (SELECT  KdBrg,Qty FROM  tblIvGstk where KdGd='SS') AS SS ON SS.KdBrg = tblIvMst.KdBrg 
order by SP.Qty DESC";
          $myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        }
        while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
        ?>

                <tr>
                    <td></td>
                    <td><?php echo $kolomData['NmType']; ?> </td>
                    <td><a href="#modal-open" data-id='<?php echo $kolomData['KdBrg']; ?>'
                            data-toggle='modal'><?php echo $kolomData['KdBrg']; ?> </td>
                    <td><?php echo $kolomData['NmBrg']; ?> </td>
                    <td><?php echo number_format($kolomData['QtySP']); ?></td>
                    <td><?php echo number_format($kolomData['QtyCB']); ?></td>
                    <td><?php echo number_format($kolomData['QtyX']); ?></td>
                    <td><?php echo number_format($kolomData['QtyCBX']); ?></td>
                    <td><?php echo number_format($kolomData['QtySS']); ?></td>
                    <td class="angkaL"><?php echo $kolomData['Satuan']; ?> </td>
                    <td><?php echo number_format($kolomData['HrgJual']); ?></td>
                    <td><?php if ($LevelLogin == "admin") {
                  echo number_format($kolomData['HrgJualMin']);
                } else {
                  echo 0;
                } ?></td>


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