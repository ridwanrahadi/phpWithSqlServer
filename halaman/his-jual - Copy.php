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
            <div align="left" class="panel-heading">HISTORY PENJUALAN</div>
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
                        <label>Input kode barang :</label>
                        <input type="form-text" class="form-control" name="txtcari1" id="txtcari1"
                            value="<?php echo $kodebarang; ?>" placeholder="Kode Barang">
                        <label>Cari Kode / Nama Customer :</label><br>
                        <select name="txtcari2" style='width: 300px;' id="txtcari2">
                            <option value=<?php echo "$nmcust"; ?>><?php echo "$nmcust";  ?></option>
                        </select>

                    </div>



                    <div class="form-group">
                        <?php if ($LevelLogin == "admin") {
                            # code...
                            $data = $KdSales;
                        } else {
                            $data = $user;
                        } ?>
                        <input type="hidden" class="form-control" name="txtcari3" id="txtcari3"
                            value="<?php echo $data; ?>">
                    </div>

                    <button type="submit" name="cari" class="btn btn-primary">Submit</button>
                    <button onclick="reset_customer_select2()" class="btn btn-warning">clear</button>
                    <br><br>

                </form>
            </div>
            <div class="panel-footer"><small>Data akan ditampikan max 1000 baris, gunakan filter lebih spesifik agar
                    data yang dicari dapat ditampilkan...</small></div>
        </div>



        <div class="jumbotron">
            <form action="" method="POST" onSubmit="return validasi()">
                <div class="form-group">
                    <label>Search JL :</label>
                    <input type="form-text" class="form-control" name="txtcariJL" id="txtcariJL"
                        value="<?php echo $NoJL; ?>" placeholder="No Faktur">
                </div>
                <button type="submit" name="cariJL" class="btn btn-primary">Submit</button>

            </form>
        </div>

        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Customer</th>
                    <th>NoFaktur</th>
                    <th>TglFak</th>
                    <th>Kode Brg</th>
                    <th>Nama Brg</th>
                    <th>Qty</th>
                    <th>Sat</th>
                    <th>Harga</th>
                    <th>Disc1</th>
                    <th>Disc2</th>
                    <th>Disc3</th>
                    <th>Jumlah</th>
                    <th>Sales</th>
                    <th>Cetak</th>
                    <th>Proses Kirim</th>
                    <th>Terkirim</th>
                </tr>
            </thead>
            <tbody>
                <?php
                # Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
                $querysql = "SELECT TOP 1000 TblFak.NoBukti, TblFak.Tgl, TblFak.KdCust, TblFak.NmCust, TblFak.KdSales, TblFakDtl.KdBrg, TblFakDtl.NmBrg, TblFakDtl.Qty, TblFakDtl.Satuan, TblFakDtl.Hrg, TblFakDtl.PrsDisc, TblFakDtl.PrsDisc2, TblFakDtl.PrsDisc3, 
                TblFakDtl.Jumlah, TblFak.Kirim, TblFak.Cetak, tblRekapKirimInvoices.Terkirim, tblRekapKirimInvoices.LPB
                FROM TblFak INNER JOIN
                TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti LEFT OUTER JOIN
                tblRekapKirimInvoices ON TblFak.NoBukti = tblRekapKirimInvoices.NoFaktur";
                if (isset($_POST['cari'])) {
                    $tglAwal = $_POST['tanggal_awal'];
                    $tglAkhir = $_POST['tanggal_akhir'];
                    $txtcari1 = $_POST['txtcari1'];
                    $txtcari2 = $_POST['txtcari2'];
                    $txtcari3 = $_POST['txtcari3'];
                    if ($txtcari1 != '' and $txtcari2 != '' and $txtcari3) {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "'  and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdCust like '%" . $txtcari2 . "%' and TblFak.KdSales like '" . $txtcari3 . "' and TblFak.NonStock='0'
ORDER by TblFak.Tgl ASC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } elseif ($txtcari1 != '' and $txtcari2 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdCust like '%" . $txtcari2 . "%' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } elseif ($txtcari1 != '' and $txtcari3 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdSales like '" . $txtcari3 . "' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } elseif ($txtcari2 != '' and $txtcari3 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust like '%" . $txtcari2 . "%' and TblFak.KdSales like '" . $txtcari3 . "' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));;
                    } elseif ($txtcari1 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } elseif ($txtcari2 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust like '%" . $txtcari2 . "%' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } elseif ($txtcari3 != '') {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdSales like '" . $txtcari3 . "' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    } else {
                        $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.NonStock='0' 
ORDER by TblFak.Tgl DESC ";
                        $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                    }
                } else if (isset($_POST['cariJL'])) {
                    $NoJL = $_POST['txtcariJL'];
                    $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.NoBukti = '" . $NoJL . "' and TblFak.NonStock='0'";
                    $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                } else {
                    $mySql = "SELECT TOP 10 TblFak.NoBukti, TblFak.Tgl, TblFak.KdCust, TblFak.NmCust, TblFak.KdSales, TblFakDtl.KdBrg, TblFakDtl.NmBrg, TblFakDtl.Qty, TblFakDtl.Satuan, TblFakDtl.Hrg, TblFakDtl.PrsDisc, TblFakDtl.PrsDisc2, TblFakDtl.PrsDisc3, 
                    TblFakDtl.Jumlah, TblFak.Kirim, TblFak.Cetak, tblRekapKirimInvoices.Terkirim, tblRekapKirimInvoices.LPB
                    FROM TblFak INNER JOIN
                    TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti LEFT OUTER JOIN
                    tblRekapKirimInvoices ON TblFak.NoBukti = tblRekapKirimInvoices.NoFaktur
Where TblFak.JnsTrans ='JL' and  TblFak.NonStock='0' and TblFak.KdSales like '$user'
ORDER by TblFak.Tgl DESC ";
                    $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                }
                while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {

                    # Membaca Kode Penjualan/ Nomor transaksi
                    $noNota = $kolomData['no_penjualan'];
                ?>

                <tr>
                    <td></td>
                    <td style="font-size: 11px"><?php echo $kolomData['NmCust']; ?></td>
                    <td style="font-size: 11px"><a href="#modal-rekap" data-id='<?php echo $kolomData['NoBukti']; ?>'
                            data-toggle='modal'><?php echo $kolomData['NoBukti']; ?></a></td>
                    <td style="font-size: 11px"><?php
                                                    $Date = $kolomData['Tgl']->format('d/m/Y');
                                                    echo $Date; ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['KdBrg']; ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['NmBrg']; ?></td>
                    <td style="font-size: 11px"><?php echo number_format($kolomData['Qty']); ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['Satuan']; ?></td>
                    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['Hrg']); ?></td>
                    <td style="font-size: 11px"> <?php echo $kolomData['PrsDisc']; ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['PrsDisc2']; ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['PrsDisc3']; ?></td>
                    <td style="font-size: 11px" align="right"><?php echo number_format($kolomData['Jumlah']); ?></td>
                    <td style="font-size: 11px"><?php echo $kolomData['KdSales']; ?></td>
                    <td style="font-size: 11px" align="center">
                        <?php if ($kolomData['Cetak'] == '1') {
                                echo "&#10004;";
                            } ?>

                    </td>
                    <td style="font-size: 11px" align="center">
                        <?php if ($kolomData['Kirim'] == '1') {
                                echo "&#10004;";
                            } ?>

                    </td>
                    <td style="font-size: 11px" align="center">
                        <?php if ($kolomData['Terkirim'] == '1') {
                                echo "&#10004;";
                            } elseif ($kolomData['LPB'] == '1') {
                                echo "LPB";
                            } ?>

                    </td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>


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
    <script>
    $(document).ready(function() {
        $('#modal-rekap').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'halaman/aksi2.php',
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