<?php include_once "deleteso.php"; ?>
<?php
$user = $_SESSION['username'];
$tglAwal  = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : date('m-d-Y');
$tglAkhir   = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : date('m-d-Y');
$kodebarang   = isset($_POST['txtcari1']) ? $_POST['txtcari1'] : '';
$nmcust   = isset($_POST['txtcari2']) ? $_POST['txtcari2'] : '';
$kdsales    = isset($_POST['txtcari3']) ? $_POST['txtcari3'] : '';
?>
<!DOCTYPE html>
<html>

<head>
    <!-- ... -->

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />




    <script>
    $(document).ready(function() {
        $('#modal-detail').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'halaman/detail-so.php',
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


    <div class="container">
        <div class="panel panel-default">
            <div align="left" class="panel-heading">DATA SALES ORDER</div>
            <div class="panel-body">
                <form action="" method="POST" onSubmit="return validasi()">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="form-text" class="datepicker" name="tanggal_awal" id="date"
                            value="<?php echo $tglAwal; ?>" readonly="">
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
                        <input type="form-text" class="datepicker" name="tanggal_akhir" id="date2"
                            value="<?php echo $tglAkhir; ?>" readonly="">
                        <script>
                        $('#date2').datepicker({
                            format: 'mm-dd-yyyy',
                            autoclose: true,
                            todayHighlight: true,


                        });
                        </script>
                    </div>

                    <div class="form-group">
                        <?php if ($LevelLogin == "admin") {
              # code...
              $data = $KdSales;
            } else {
              $data = $user;
            } ?>
                        <label>Input :</label>
                        <input type="form-text" class="form-control" name="txtcari2" value="<?php echo $nmcust; ?>"
                            placeholder="Nama Customer">
                        <input type="hidden" class="form-control" name="txtcari3" id="txtcari3"
                            value="<?php echo $data; ?>">
                    </div>

                    <button type="submit" name="cari" class="btn btn-primary">Submit</button><br><br>

                </form>
            </div>
            <div class="panel-footer"><small>Data akan ditampikan max 1000 baris, gunakan filter lebih spesifik agar
                    data yang dicari dapat ditampilkan...</small></div>
        </div>
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Customer</th>
                    <th>NoSO</th>
                    <th>NoPO</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>KdSales</th>
                    <th>Total SO non PPN</th>
                    <th>Approval</th>
                    <th>Keterangan Akunting</th>
                    <th>Opsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
        # Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
        # filter tampil data SO
        $querysql = "SELECT TOP 1000 salesorder.no_so, salesorder.no_po, salesorder.tgl_so, salesorder.jam, tblCustomer.NmCust, salesorder.grandtotal, salesorder.approved, salesorder.keterangan2,salesorder.kd_user,salesorder.batal,salesorder.proses,TblFak.NoBukti
        FROM salesorder LEFT OUTER JOIN TblFak ON salesorder.no_so = TblFak.NoSO LEFT OUTER JOIN tblCustomer ON salesorder.kd_cust = tblCustomer.KdCust";
        if (isset($_POST['cari'])) {
          $tglAwal = $_POST['tanggal_awal'];
          $tglAkhir = $_POST['tanggal_akhir'];
          $txtcari2 = $_POST['txtcari2'];
          $txtcari3 = $_POST['txtcari3'];
          if ($txtcari2 != '' and $txtcari3 != '') {
            $mySql = "$querysql
Where salesorder.tgl_so between '" . $tglAwal . "' AND '" . $tglAkhir . "' and tblCustomer.NmCust like '%" . $txtcari2 . "%' and salesorder.kd_user='" . $_SESSION['username'] . "'
ORDER by salesorder.no_so ASC ";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
          } elseif ($txtcari3 != '') {
            $mySql = "$querysql
Where salesorder.tgl_so between '" . $tglAwal . "' AND '" . $tglAkhir . "' and salesorder.kd_user='" . $_SESSION['username'] . "'
ORDER by salesorder.no_so ASC ";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
          } elseif ($txtcari2 != '') {
            $mySql = "$querysql
Where salesorder.tgl_so between '" . $tglAwal . "' AND '" . $tglAkhir . "' and tblCustomer.NmCust like '%" . $txtcari2 . "%'
ORDER by salesorder.no_so ASC ";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
          } else {
            $mySql = "$querysql
Where salesorder.tgl_so between '" . $tglAwal . "' AND '" . $tglAkhir . "'
ORDER by salesorder.no_so ASC ";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
          }
        } else {
          $mySql = "$querysql
Where salesorder.tgl_so between '" . $tglAwal . "' AND '" . $tglAkhir . "' and salesorder.kd_user='" . $_SESSION['username'] . "'
ORDER by salesorder.no_so ASC ";
          $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        }
        while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
          $id       = $kolomData['no_so'];
          $NoBukti  = $kolomData['NoBukti'];
        ?>

                <tr>
                    <td></td>
                    <td><?php echo $kolomData['NmCust']; ?></td>
                    <td><a href="#modal-detail" data-id='<?php echo $kolomData['no_so']; ?>'
                            data-toggle='modal'><?php echo $kolomData['no_so']; ?></a></td>
                    <td><?php echo $kolomData['no_po']; ?></td>
                    <td><?php
                $Date = $kolomData['tgl_so']->format('d-m-Y');
                echo $Date; ?></td>
                    <td><?php
                $jam = $kolomData['jam']->format('H:i:s');
                echo $jam; ?></td>
                    <td><?php echo $kolomData['kd_user']; ?></td>
                    <td align="right"><?php echo number_format($kolomData['grandtotal']); ?></td>
                    <td><?php

                if ($kolomData['approved'] == '1' && $kolomData['proses'] == '1') {
                  echo "Disetujui";
                } elseif ($kolomData['proses'] == '1') {
                  echo "Diproses";
                } else {
                  echo "";
                } ?></td>
                    <td><?php echo $kolomData['keterangan2']; ?></td>

                    <td class='text-center'><a href="?page=Data_SalesOrder&Act=DeleteSo&id=<?php echo $id; ?>"
                            target="_self"><i class='btn btn-primary'>Delete</i></a></td>
                    <td><?php if ($NoBukti == '') {
                  if ($kolomData['batal'] == '1') {
                    echo "Batal";
                  } elseif ($kolomData['approved'] == '1') {
                    echo "Nunggu Cetak";
                  }
                } else {
                  echo $NoBukti;
                }

                ?>



                    </td>
                </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>

    <div id="modal-detail" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Item</h4>
                </div>
                <div class="modal-body">
                    <div class="hasil-data"></div>

                </div>
            </div>

        </div>
    </div>

</body>

</html>