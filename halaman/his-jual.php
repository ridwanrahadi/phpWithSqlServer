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
    <style type="text/css">
    #btn-back {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        z-index: 2
    }
    </style>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


</head>

<body>
    <button type="button" class="btn btn-primary btn-xs" id="btn-back">To Top</button>
    <div class="container">
        <div class="panel panel-default">
            <div align="left" class="panel-heading">HISTORY PENJUALAN</div>
            <div class="panel-body">
                <form action="" method="POST">

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
                            </option>
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
            <div class="panel-footer"><small>Data akan ditampikan max 500 baris, gunakan filter lebih spesifik agar
                    data yang dicari dapat ditampilkan...</small></div>
        </div>



        <div class="jumbotron">
            <form action="" method="POST" onSubmit="return validasi()">
                <div class="form-group">
                    <label>Search JL :</label>
                    <input type="form-text" class="form-control" name="txtcariJL" id="txtcariJL"
                        value="<?php echo $NoJL; ?>" placeholder="No Faktur">
                </div>
                <button type="submit" name="cariJL" class="btn btn-warning">Submit</button>

            </form>
        </div>
        <?php

        # Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
        $querysql = "SELECT top 500 TblFak.NoBukti, TblFak.Tgl, TblFak.KdCust, TblFak.NmCust, TblFak.KdSales, TblFakDtl.KdBrg, TblFakDtl.NmBrg, TblFakDtl.Qty, TblFakDtl.Satuan, TblFakDtl.Hrg, TblFakDtl.PrsDisc, TblFakDtl.PrsDisc2, TblFakDtl.PrsDisc3, 
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
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "'  and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdCust = '" . $txtcari2 . "' and TblFak.KdSales ='" . $txtcari3 . "' 
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari1 != '' and $txtcari2 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdCust = '" . $txtcari2 . "'  
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdCust = '" . $txtcari2 . "'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari1 != '' and $txtcari3 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari2 != '' and $txtcari3 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust = '" . $txtcari2 . "' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust = '" . $txtcari2 . "' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari1 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%'  
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFakDtl.KdBrg like '%" . $txtcari1 . "%'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari2 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust = '" . $txtcari2 . "' 
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdCust = '" . $txtcari2 . "' 
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } elseif ($txtcari3 != '') {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $mySql1 = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdSales ='" . $txtcari3 . "'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            } else {
                $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "'  
ORDER by TblFak.NoBukti DESC";
                $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
            }
        } else if (isset($_POST['cariJL'])) {
            $NoJL = $_POST['txtcariJL'];
            $mySql = "$querysql
Where TblFak.JnsTrans ='JL' and  TblFak.NoBukti = '" . $NoJL . "' ";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        } else {
            $mySql = "SELECT top 10 TblFak.NoBukti, TblFak.Tgl, TblFak.KdCust, TblFak.NmCust, TblFak.KdSales, TblFakDtl.KdBrg, TblFakDtl.NmBrg, TblFakDtl.Qty, TblFakDtl.Satuan, TblFakDtl.Hrg, TblFakDtl.PrsDisc, TblFakDtl.PrsDisc2, TblFakDtl.PrsDisc3, 
    TblFakDtl.Jumlah, TblFak.Kirim, TblFak.Cetak, tblRekapKirimInvoices.Terkirim, tblRekapKirimInvoices.LPB
    FROM TblFak INNER JOIN
    TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti LEFT OUTER JOIN
    tblRekapKirimInvoices ON TblFak.NoBukti = tblRekapKirimInvoices.NoFaktur
Where TblFak.JnsTrans ='JL' and  TblFak.Tgl between '" . $tglAwal . "' AND '" . $tglAkhir . "' and TblFak.KdSales = '" . $user . "'
ORDER by TblFak.NoBukti DESC";
            $myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
        }
        while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {

        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <?php echo $kolomData['NmCust']; ?>
                <h5><a href="#modal-rekap" data-id='<?php echo $kolomData['NoBukti']; ?>'
                        data-toggle='modal'><?php echo $kolomData['NoBukti']; ?></a></h5>
            </div>
            <div class="panel-body">
                <h3 class="text-center"><?php echo $kolomData['KdSales']; ?></h3>
                <h4><?php echo $kolomData['KdBrg'] . " - " . $kolomData['NmBrg']; ?></h4>
            </div>
            <!-- List group -->
            <ul class="list-group">
                <li class="list-group-item">
                    <?php echo "Qty : " . number_format($kolomData['Qty']) . "-" . $kolomData['Satuan'] . " Harga : " . number_format($kolomData['Hrg']); ?>
                </li>
                <li class="list-group-item">
                    <?php echo  "Disc1 : " . $kolomData['PrsDisc'] . " Disc2 : " . $kolomData['PrsDisc2'] . " Disc3 : " . $kolomData['PrsDisc3']; ?>
                </li>
                <li class="list-group-item">
                    <?php echo "Sub Total : " . number_format($kolomData['Jumlah']) ?>
                </li>
            </ul>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-12 col-md-8"><?php $Date = $kolomData['Tgl']->format('d/m/Y');
                                                        echo "Tanggal Cetak : " . $Date;
                                                        ?></div>
                    <div class="col-xs-4 col-sm-3"><?php if ($kolomData['Cetak'] == '1') {
                                                            echo "Cetak :" . "&#10004;";
                                                        } ?></div>
                    <div class="col-xs-4 col-sm-3"> <?php if ($kolomData['Kirim'] == '1') {
                                                            echo "Dikirim :" . "&#10004;";
                                                        } ?></div>
                    <div class="col-xs-4 col-sm-3"> <?php if ($kolomData['Terkirim'] == '1') {
                                                            echo "Terkirim : " . "&#10004;";
                                                        } elseif ($kolomData['LPB'] == '1') {
                                                            echo "LPB";
                                                        } ?></div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- <div class="text-center">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?php if ($pagenumber > 1) {
                                                    echo "href='?page=History_Penjualan&halaman=$Previous'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    for ($x = 1; $x <= $total_halaman; $x++) {
                    ?>
                    <li class="page-item"><a class="page-link"
                            href="?page=History_Penjualan&halaman=<?php echo $x ?>"><?php echo $x; ?></a>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="page-item">
                        <a class="page-link" <?php if ($pagenumber < $total_halaman) {
                                                    echo "href='?page=History_Penjualan&halaman=$next'";
                                                } ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div> -->

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
                url: 'halaman/data-kiriman.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.hasil-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    //Get the button
    let mybutton = document.getElementById("btn-back");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    </script>
</body>

</html>