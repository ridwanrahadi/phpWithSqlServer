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
                url: 'halaman/expired.php',
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
    <h3 align="center">INVENTORY EXPIRED</h3>
    <div class="container">
        <div class="jumbotron">

            <form action="" method="POST">

                <div class="form-group">

                    <label>Cari Data</label>
                    <input type="form-text" name="txtcari" class="form-control" id="search" placeholder="Kode Barang"
                        required="">
                    <small class="form-text text-muted">Input data dengan benar.</small>
                </div>
                <button type="submit" name="cari" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="container">
        <table id="tabelinventory" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>

                    <th>Kode Barang</th>
                    <th>Tanggal Expired</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>No BL</th>
                </tr>
            </thead>
            <tbody>
                <?php

        $nomor = 1;
        $txtcari = $_POST['txtcari'];
        if ($txtcari != '') {
          $mySql  = "SELECT NoBukti,KdBrg,NmBrg,Qty,Satuan,ISNULL(Tglexpired,0) As TanggalExpired 
FROM tblBeliDtl 
Where tblBeliDtl.KdBrg = '" . $txtcari . "' and Qty > 0
order by NoBukti DESC";
          $myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        } else {
          $mySql  = "SELECT TOP 1000 NoBukti,KdBrg,NmBrg,Qty,Satuan,ISNULL(Tglexpired,0) As TanggalExpired 
FROM tblBeliDtl 
where Qty > 0 
order by NoBukti DESC";
          $myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        }
        while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
        ?>

                <tr>
                    <td><?php echo $nomor++; ?></td>

                    <td><a href="#modal-open" data-id='<?php echo $kolomData['KdBrg']; ?>'
                            data-toggle='modal'><?php echo $kolomData['KdBrg']; ?> </td>
                    <td><?php $Date =  $kolomData['TanggalExpired']->format('d/m/Y');
                echo $Date ?></td>
                    <td><?php echo $kolomData['NmBrg']; ?> </td>
                    <td><?php echo $kolomData['Qty']; ?></td>
                    <td><?php echo $kolomData['Satuan']; ?></td>
                    <td><?php echo $kolomData['NoBukti']; ?> </td>

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