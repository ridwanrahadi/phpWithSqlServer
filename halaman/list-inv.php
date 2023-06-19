<?php error_reporting(E_ALL ^ E_NOTICE); ?>
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


</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div align="left" class="panel-heading">Invoice List Piutang Customer</div>
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
                        <label>Cari Kode / Nama Customer :</label><br>
                        <select name="txtcari2" style='width: 300px;' id="txtcari2">
                            <option value=<?php echo "$nmcust"; ?>><?php echo "$nmcust";  ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="cari" class="btn btn-primary">Submit</button>
                        <button onclick="reset_customer_select2()" class="btn btn-warning">clear</button>
                    </div>
                </form>
                <div class="pull-right">
                    <?php if ($LevelLogin == "admin") {
                        # code...
                        $type = "btn btn-primary";
                    } else {
                        $type = "hidden";
                    } ?>
                    <button type="button" class="<?= $type; ?>" data-toggle="modal" data-target="#modal-rekap"
                        id="submit">Update kredit limit</button>
                </div>
            </div>
            <div class="panel-footer"><small>Data akan ditampikan max 1000 baris, gunakan filter lebih spesifik agar
                    data yang dicari dapat ditampilkan...</small></div>
        </div>


        <table id="example3" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>No Invoice</th>
                    <th>Nilai</th>
                    <th>No KWT</th>
                    <th>Lunas</th>
                    <th>No Pelunasan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                # Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
                $querysql = "SELECT top 1000 TblFak.NoBukti, TblFak.JnsTrans, TblFak.KdCust, TblFak.NmCust, TblFak.Total, TblFak.NoTagih, TblFak.Kembali, tblReceivDtlFak.NoBukti AS NoPP, TblFak.Lunas, TblFak.Tgl
                FROM TblFak LEFT OUTER JOIN tblReceivDtlFak ON TblFak.NoBukti = tblReceivDtlFak.NoFak";
                if (isset($_POST['cari'])) {
                    $tglAwal = $_POST['tanggal_awal'];
                    $tglAkhir = $_POST['tanggal_akhir'];
                    $txtcari2 = $_POST['txtcari2'];
                    if ($txtcari2 != '') {
                        $mySql = "$querysql
                    Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust = '" . $txtcari2 . "' 
                    ORDER by TblFak.Tgl ASC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    }

                    while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {

                        # Membaca Kode Penjualan/ Nomor transaksi
                        $noNota = $kolomData['no_penjualan'];
                ?>

                <tr>
                    <td style="font-size: 11px"><?php echo $kolomData['NmCust']; ?></td>
                    <td style="font-size: 11px"><?php
                                                        $Date = $kolomData['Tgl']->format('d/m/Y');
                                                        echo $Date; ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['NoBukti']; ?></td>
                    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['Total']); ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['NoTagih']; ?></td>
                    <td style="font-size: 11px" align="center">
                        <?php if ($kolomData['Lunas'] == '1') {
                                    echo "&#10004;";
                                } ?>
                    <td style="font-size: 11px"><?php echo $kolomData['NoPP']; ?></td>

                </tr>
                <?php }
                } ?>
            </tbody>

        </table>
    </div>

    <form action="" method="POST">
        <div id="modal-rekap" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Kredit Limit</h4>
                    </div>
                    <div class="modal-body">
                        <div class="hasil-data"></div>

                    </div>
                </div>

            </div>
        </div>
    </form>
    <?php
    //Tombol update kredit limit
    if (isset($_POST['btnupdate'])) {
        $id_cust = $_POST['id_cust'];
        $txtkredit = $_POST['kredit'];
        $checkbox = $_POST['whitelist'];
        $checkbox2 = $_POST['proteklimit'];
        if ($checkbox == "on") {
            $whitelist = 1;
        } else {
            $whitelist = 0;
        }
        if ($checkbox2 == "on") {
            $proteklimit = 1;
        } else {
            $proteklimit = 0;
        }
        //set terkirim
        $updateSql = "UPDATE tblCustomer SET KreditLimit = '$txtkredit',whitelist='$whitelist',ProtekLimit='$proteklimit' WHERE KdCust='" . $id_cust . "'";
        sqlsrv_query($conn, $updateSql) or die(print_r(sqlsrv_errors(), true));
        echo "<script>alert('Kredit limit : {$id_cust} Berhasil Diupdate !!!');</script>";
    }
    ?>
    <script>
    $(document).ready(function() {
        $('#modal-rekap').on('show.bs.modal', function(e) {
            var idx = $("#txtcari2").val();
            $.ajax({
                type: 'post',
                url: 'halaman/update_kredit_limit.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.hasil-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    </script>
</body>

</html>