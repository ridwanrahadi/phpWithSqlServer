<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
$user = $_SESSION['username'];
$txtcari   = isset($_POST['txtcari']) ? $_POST['txtcari'] : '';
?>
<!DOCTYPE html>
<html>

<head>
    <script>

    </script>
</head>

<body onload="getLocation()">
    <h3 align="center">PENGIRIMAN</h3>
    <div class="container">
        <div class="jumbotron">
            <form id="form1" enctype="multipart/form-data" method="post" action="">
                <div class="form-group">
                    <label>Cari Data</label>
                    <input type="form-text" name="txtcari" class="form-control" id="txtcari"
                        value="<?php echo $txtcari; ?>" placeholder="No Expedisi / No JL">
                    <small class="form-text text-muted">Input data dengan benar.</small>
                </div>
                <div class="form-group">
                    <button type="submit" name="cari" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
    <div class="container">
        <table id="tabelinventory" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No SPK</th>
                    <th>No JL</th>
                    <th>Supir</th>
                    <th>Action</th>
                    <th>Tanggal SPK</th>
                    <th>Nama Customer</th>
                    <th>Sales</th>
                    <th>Alamat</th>
                    <th>Koordinat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $txtcari = $_POST['txtcari'];
                $tgl =  date('m-d-Y');

                if ($txtcari != '') {
                    $mySql  = "SELECT  tblRekapKirim.NoBukti,tblRekapKirim.Supir, tblRekapKirim.Tanggal, tblRekapKirimInvoices.NoFaktur, TblFak.NmCust, TblFak.Alm1, TblFak.Alm2, TblFak.Alm3, tblCustomer.Koordinat, tblSalesPerson.NMSALES,tblRekapKirimInvoices.Terkirim,tblRekapKirimInvoices.LPB
                        FROM    tblRekapKirim INNER JOIN
                                tblRekapKirimInvoices ON tblRekapKirim.NoBukti = tblRekapKirimInvoices.NoBukti INNER JOIN
                                TblFak ON tblRekapKirimInvoices.NoFaktur = TblFak.NoBukti INNER JOIN
                                tblCustomer ON TblFak.KdCust = tblCustomer.KdCust INNER JOIN
                                tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                        Where   tblRekapKirim.NoBukti = '" . $txtcari . "' OR tblRekapKirimInvoices.NoFaktur = '" . $txtcari . "'";
                } else {
                    $mySql  = "SELECT  tblRekapKirim.NoBukti,tblRekapKirim.Supir,tblRekapKirim.NoMobil, tblRekapKirim.Tanggal, tblRekapKirimInvoices.NoFaktur, TblFak.NmCust, TblFak.Alm1, TblFak.Alm2, TblFak.Alm3, tblCustomer.Koordinat, tblSalesPerson.NMSALES,tblRekapKirimInvoices.Terkirim,tblRekapKirimInvoices.LPB
                        FROM    tblRekapKirim INNER JOIN
                                tblRekapKirimInvoices ON tblRekapKirim.NoBukti = tblRekapKirimInvoices.NoBukti INNER JOIN
                                TblFak ON tblRekapKirimInvoices.NoFaktur = TblFak.NoBukti INNER JOIN
                                tblCustomer ON TblFak.KdCust = tblCustomer.KdCust INNER JOIN
                                tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                        Where   tblRekapKirim.NoMobil = '" . $user . "' AND tblRekapKirim.Tanggal = '" . $tgl . "'";
                }
                $myQry  = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
                while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
                ?>

                <tr>
                    <td><?php echo $kolomData['NoBukti']; ?> </td>
                    <td><?php echo $kolomData['NoFaktur']; ?> </td>
                    <td><?php echo $kolomData['Supir']; ?> </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-list-alt"></span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#modal-terkirim" data-id='<?php echo $kolomData['NoFaktur']; ?>'
                                        data-toggle='modal'>Terkirim</a></li>
                                <li><a href="#modal-lpb" data-id='<?php echo $kolomData['NoFaktur']; ?>'
                                        data-toggle='modal'>LPB</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><?php $Date = $kolomData['Tanggal']->format('d-m-Y');
                            echo $Date; ?></td>
                    <td><?php echo $kolomData['NmCust']; ?> </td>
                    <td><?php echo $kolomData['NMSALES']; ?> </td>
                    <td><?php echo $kolomData['Alm1'] . " " . $kolomData['Alm2'] . " " . $kolomData['Alm3']; ?> </td>
                    <td style="text-align:right;"><a
                            href="https://www.google.com/maps/search/?api=1&query=<?php echo $kolomData['Koordinat']; ?>"><?php echo $kolomData['Koordinat']; ?></a>
                    </td>
                    <td> <?php if ($kolomData['Terkirim'] == '1') {
                                    echo "Terkirim";
                                } elseif ($kolomData['LPB'] == '1') {
                                    echo "LPB";
                                } ?> </td>

                </tr>

                <?php }
                ?>
            </tbody>

        </table>

    </div>
    <!-- Form Modal proses terkirim-->
    <form action="" method="POST">
        <div id="modal-terkirim" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Apakah akan proses terkirim ?</h4>
                    </div>
                    <div class="modal-body">
                        <input type="input-text" id="koordinat" name="koordinat" hidden />
                        <div id="map" style="width:100%;height:400px;"></div>
                        <script src="https://maps.googleapis.com/maps/api/js?key=&callback=" async defer>
                        </script>
                        <div class="hasil-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
    //Tombol proses kirim di klik
    if (isset($_POST['kirim'])) {
        $id_nobukti = $_POST['id_nobukti'];
        $koordinat = $_POST['koordinat'];
        $now = date_create();
        $jam = date_format($now, 'Y-m-d H:i:s');
        $myQry = "SELECT * FROM tblRekapKirimInvoices WHERE NoFaktur='" . $id_nobukti . "'";
        $mySql  = sqlsrv_query($conn, $myQry) or die(print_r(sqlsrv_errors(), true));
        $kolomData = sqlsrv_fetch_array($mySql);
        //Cek apakah sudah kirim
        if ($kolomData['Terkirim'] == 1) {
            echo "<script>alert('Proses GAGAL Nomor : {$id_nobukti} Sudah dilakukan pengiriman !!!');</script>";
            //Cek apakah sudah LPB
        } elseif ($kolomData['LPB'] == 1) {
            echo "<script>alert('Proses GAGAL Nomor : {$id_nobukti} Sudah LPB !!!');</script>";
        } else {
            //set terkirim
            $updateSql = "UPDATE tblRekapKirimInvoices SET Terkirim = 1 ,Jam_terkirim ='$jam' WHERE NoFaktur='" . $id_nobukti . "'";
            sqlsrv_query($conn, $updateSql) or die(print_r(sqlsrv_errors(), true));
            echo "<script>alert('Nomor : {$id_nobukti} Berhasil Terkirim !!!');</script>";
        }
    }
    ?>

    <!-- Form Modal LPB-->
    <form class="form-horzontal" id="form1" action="" enctype="multipart/form-data" method="POST">
        <div id="modal-lpb" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Proses LBP ?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="hasil-data"></div>

                    </div>
                </div>

            </div>
        </div>
    </form>
    <?php
    // check ukuran gambar
    function convert_filesize($bytes, $decimals = 2)
    {
        $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
    function compressImage($source, $destination, $quality)
    {
        // Get image info 
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Create a new image from file 
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                $angel = 270;
                $rotate = imagerotate($image, $angel, 0);
                break;
            case 'image/jpg':
                $image = imagecreatefromjpeg($source);
                $angel = 270;
                $rotate = imagerotate($image, $angel, 0);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                $angel = 270;
                $rotate = imagerotate($image, $angel, 0);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                $angel = 270;
                $rotate = imagerotate($image, $angel, 0);
                break;
            default:
                $image = imagecreatefromjpeg($source);
                $angel = 270;
                $rotate = imagerotate($image, $angel, 0);
        }

        // Save image 
        imagejpeg($rotate, $destination, $quality);

        // Return compressed image 
        return $destination;
    }
    //Tombol proses kirim di klik
    if (isset($_POST['lpb'])) {
        $id_nobukti = $_POST['id_nobukti'];
        $now = date_create();
        $jam = date_format($now, 'Y-m-d H:i:s');
        $keterangan = $_POST['keterangan'];
        $myQry = "SELECT * FROM tblRekapKirimInvoices WHERE NoFaktur='" . $id_nobukti . "'";
        $mySql  = sqlsrv_query($conn, $myQry) or die(print_r(sqlsrv_errors(), true));
        $kolomData = sqlsrv_fetch_array($mySql);
        //Cek apakah sudah kirim
        if ($kolomData['Terkirim'] == 1) {
            echo "<script>alert('Proses GAGAL Nomor : {$id_nobukti} Sudah dilakukan pengiriman !!!');</script>";
            //Cek apakah sudah LPB
        } elseif ($kolomData['LPB'] == 1) {
            echo "<script>alert('Proses GAGAL Nomor : {$id_nobukti} Sudah LPB !!!');</script>";
        } else {
            //set LPB
            $updateSql = "UPDATE tblRekapKirimInvoices SET LPB = 1,Keterangan_LPB='$keterangan',Jam_terkirim ='$jam' WHERE NoFaktur='" . $id_nobukti . "'";
            sqlsrv_query($conn, $updateSql) or die(print_r(sqlsrv_errors(), true));
            if ($updateSql) {
                if ($_FILES["file_image"]["name"] != '') // check file sudah dipilih atau belum
                {
                    $allowed_ext = array("jpg", "png", "jpeg"); // extension file yang di ijinkan
                    $ext = end(explode('.', $_FILES["file_image"]["name"])); // upload file ext
                    if (in_array($ext, $allowed_ext)) // check untuk validextension extension
                    {


                        $name = $id_nobukti . "." . $ext; // rename nama file gambar
                        $path = "uploads/" . $name; // image upload path

                        // Image temp source and size
                        $imageTemp = $_FILES["file_image"]["tmp_name"];
                        $imageSize = convert_filesize($_FILES["file_image"]["size"]);

                        // Compress size and upload image 
                        $compressedImage = compressImage($imageTemp, $path, 50);
                        if ($compressedImage) {
                            $compressedImageSize = filesize($compressedImage);
                            $compressedImageSize = convert_filesize($compressedImageSize);
                        }
                        //move_uploaded_file($_FILES["file_image"]["tmp_name"], $path);
                    } else {
                        echo '<script>alert("Tidak Sesuai Image File")</script>';
                    }
                } else {
                    echo '<script>alert("Silahkan pilih file gambar")</script>';
                }
            }
            echo "<script>alert('Nomor : {$id_nobukti} LPB Berhasil dibuat !!!');</script>";
        }
    }
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#modal-terkirim').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'controller/proses_terkirim.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.hasil-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    $(document).ready(function() {
        $('#modal-lpb').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'controller/proses_lpb.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.hasil-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    var x = document.getElementById("koordinat");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPos, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }


    function showPos(position) {
        latt = position.coords.latitude;
        long = position.coords.longitude;
        //tampil data koordinat
        x.value = latt + "," + long;

        var lattlong = new google.maps.LatLng(latt, long);
        var myOptions = {
            center: lattlong,
            zoom: 15,
            mapTypeControl: true,
            navigationControlOptions: {
                style: google.maps.NavigationControlStyle.SMALL
            }
        }
        // var latlng = {
        //     lat: -6.262581048548821,
        //     lng: 106.86614602804184
        // };
        // var geocoder = new google.maps.Geocoder;
        // geocoder.geocode({
        //     'location': latlng
        // }, function(results, status) {
        //     if (status === 'OK') {
        //         if (results[0]) {
        //             rs = results[0].formatted_address;
        //         } else {
        //             rs = 'No results found';
        //         }
        //     } else {
        //         rs = 'Geocoder failed due to: ' + status;
        //     }
        //     x.innerHTML = rs;
        // });
        //tampil data ke frame google map
        var maps = new google.maps.Map(document.getElementById("map"), myOptions);
        var markers =
            new google.maps.Marker({
                position: lattlong,
                map: maps,
                title: "You are here!"
            });
    }


    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }
    </script>
</body>

</html>